<?php namespace Davelip\Queue\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Queue jobs
 *
 * @property integer $id
 * @property string  $queue
 * @property integer $status
 * @property integer $attempts
 * @property integer $timestamp
 * @property integer $reserved
 * @property integer $reserved_at
 * @property integer $available_at
 * @property string  $payload
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Job extends Model
{
    const STATUS_OPEN = 0;
    const STATUS_WAITING = 1;
    const STATUS_STARTED = 2;
    const STATUS_FINISHED = 3;

    protected $table = 'queues';
    protected $guarded = array('id', 'created_at', 'updated_at');

    /**
     * attribute retries supported
     *
     * @return int
     */
    public function getRetriesAttribute()
    {
        return $this->attempts;
    }
}
