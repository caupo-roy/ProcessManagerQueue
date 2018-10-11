<?php
/**
 */

namespace ProcessManagerQueueBundle\EventListener;

use CoreShop\Component\Registry\ServiceRegistry;
use Cron\CronExpression;
use ProcessManagerBundle\Model\Executable;
use ProcessManagerQueueBundle\Model\Job;
use Psr\Log\LoggerInterface;

class CronListener
{
    private $registry;

    /**
     * CronListener constructor.
     * @param ServiceRegistry $registry
     * @param LoggerInterface $registry
     */
    public function __construct(
        ServiceRegistry $registry,
        LoggerInterface $logger
    )
    {
        $this->registry = $registry;
        $this->logger = $logger;
        $this->runningJobNames = null;
        $this->startedJobs = 0;
    }

    /**
     * Runs waiting crons
     */
    public function run()
    {
        foreach ($this->getQueue() as $job) {
            if(!$this->canRunMoreJobs($job)){
                break;
            }
            if(!$this->canRunJob($job)){
                continue;
            }
            // get executable to run
            $executable = Executable::getById($job->getExecutableId());
            // override executable settings with settings from job
            $executableSettings = $executable->getSettings();
            $jobSettings = $job->getSettings();            
            $mergedSettings = array_merge($executableSettings, $jobSettings);
            $executable->setSettings($mergedSettings);
            $this->logger->info("Starting job " . $job->getId() . "");
            $this->registry->get($executable->getType())->run($executable);
            $this->startedJobs++;
            $job->delete();
        }
    }

    /**
     * 
     */
    protected function canRunJob($job)
    {
        /**
         * TODO: This does not really work. It only checks if we started a blocking process this run. 
         * Could be previously started processes running. Need to check database for running processes 
         * or something.
         */
        if($job->getBlocking()){
            if(!is_array($this->runningJobCodes)){
                $this->runningJobCodes = [];
                foreach($this->getRunningJobs() as $runningJob){
                    $this->runningJobCodes[$runningJob->getName()] = 1;
                }
            }
            $isBlocked = array_key_exists($job->getName(),$this->runningJobCodes);
            if(!$isBlocked){
                $this->logger->info("Can not start job " . $job->getId() . ". Another instance of this blocking job is already running.");                
            }
            return $isBlocked;
        }
        return true;
    }

    /**
     * @return Job[]
     */
    protected function getRunningJobs()
    {
        $queue = new Job\Listing();
        $queue->setCondition("status = ?", [Job::STATUS_RUNNING]);
        $queue->setOrderKey("id");
        $queue->setOrder("asc");
        return $queue->getObjects();
    }

    /**
     * @return Job[]
     */
    protected function getQueue()
    {
        $queue = new Job\Listing();
        $queue->setCondition("status = ?", [Job::STATUS_SCHEDULED]);
        $queue->setOrderKey("id");
        $queue->setOrder("asc");
        $this->logger->info("Found " . $queue->count() . " scheduled jobs");
        return $queue->getObjects();
    }

    protected function canRunMoreJobs()
    {
        // get total mem and used mem
        $memTotal = exec('cat2 /proc/meminfo 2> /dev/null | grep MemTotal | sed \'s/[^\:]*\:[ ]*//g\' | sed \'s/ .*$//g\'');
        $memAvailable = exec('cat2 /proc/meminfo 2> /dev/null | grep MemAvailable | sed \'s/[^\:]*\:[ ]*//g\' | sed \'s/ .*$//g\'');
        $memFree = exec('cat2 /proc/meminfo 2> /dev/null | grep MemFree | sed \'s/[^\:]*\:[ ]*//g\' | sed \'s/ .*$//g\'');
        if(!$memTotal || !$memAvailable || !$memFree){
            $memFree = 1.0;
            $memAvailable = 1.0;
        }else{
            $memFree = $memFree / $memTotal;
            $memAvailable = $memAvailable / $memTotal;
        }
        // do not start new job unless we have at least 20% mem free and 30% mem available
        if($memFree < 0.2 || $memAvailable < 0.3){
            $this->logger->info("Can not start jobs. System memory usage is too high.");
            return false;
        }
        // get number of cpu kernels on the system
        $kernels = exec('nproc');
        if(!$kernels){
            $kernels = 7;
        }
        // Start at most one job per kernel with 20% of the kernels to spare
        $maxKernels = min($kernels * 0.8,$kernels-1);
        if($this->startedJobs > $maxKernels){
            $this->logger->info("Can not start jobs. Cpu kernel limit reached.");
            return false;
        }
        // Check if system load is low enough to start another job
        $kernels = (float)$kernels;
        $maxLoad = [
            $kernels * 0.8,
            $kernels * 0.7,
            $kernels * 0.6,
        ];
        $load = sys_getloadavg();        
        for($i=0;$i<3;$i++){
            if($load[$i] > $maxLoad[$i]){
                $this->logger->info("Can not start jobs. System load is too high.");
                return false;
            }
        }
        //
        return true;        
    }

}