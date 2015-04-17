<?php namespace Davelip\Queue;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\Queue;
use Illuminate\Queue\QueueInterface;
use Symfony\Component\Process\Process;
use Davelip\Queue\Jobs\DatabaseJob;
use Davelip\Queue\Models\Job;

class DatabaseQueue extends Queue implements QueueInterface {

	/**
	 * The name of the default tube.
	 *
	 * @var string
	 */
	protected $default;

	/**
	 * Create a new database queue instance
	 *
	 * @param  string  $default
	 * @return void
	 */
	public function __construct($default)
	{
		$this->default = $default;
	}


    /**
     * Push a new job onto the queue.
     *
     * @param  string  $job 	job
     * @param  mixed   $data	payload of job
     * @param  string  $queue	queue name
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        $id = $this->storeJob($job, $data, $queue);
        return 0;
    }

    /**
     * Store the job in the database
     *
     * @param  string  $job			job
     * @param  mixed   $data 		payload of job
     * @param  string  $queue		queue name
     * @param  integer $timestamp=0 timestamp
     * @return integer The id of the job
     */
	public function storeJob($job, $data, $queue, $timestamp = 0)
	{
        $payload = $this->createPayload($job, $data);

        $job = new Job;
        $job->queue = ($queue ? $queue : $this->default);
        $job->status = Job::STATUS_OPEN;
        $job->timestamp = date('Y-m-d H:i:s', ($timestamp!=0?$timestamp:time()));
        $job->payload = $payload;
        $job->save();

        return $job->id;
    }

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param  \DateTime|int  	$delay
     * @param  string  			$job
     * @param  mixed  			$data
     * @param  string  			$queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        $timestamp = time() + $this->getSeconds($delay);
        $id = $this->storeJob($job, $data, $queue, $timestamp);
        return 0;
    }

    /**
     * Pop the next job off of the queue.
     *
     * @param  string  $queue 	queue name
     * @return \Illuminate\Queue\Jobs\Job|null
     */
	public function pop($queue = null)
	{
		$queue = $queue ? $queue : $this->default;

		$job = Job::query()->where('queue', '=', $queue)
			->where(function(Builder $query) {
				$query->where('status', '=', Job::STATUS_OPEN);
				$query->orWhere('status', '=', Job::STATUS_WAITING);
			})
			->where('timestamp', '<', date('Y-m-d H:i:s', time()))
			->orderBy('timestamp')
			->first()
			;

		if ( ! is_null($job))
		{
			return new DatabaseJob($this->container, $job);
		}
	}


    /**
     * Push a raw payload onto the queue.
     *
     * @param  string $payload
     * @param  string $queue
     * @param  array $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = array())
    {
        //
    }
}
