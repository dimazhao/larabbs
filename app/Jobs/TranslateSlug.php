<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Str;
use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

 protected $topicId; // 改为存储ID，而非模型实例（更稳妥）

    // 构造函数接收Topic ID（而非实例）
    public function __construct(int $topicId)
    {
        $this->topicId = $topicId;
    }

    public function handle()
    {
        // 二次查询：从数据库重新获取模型，避免序列化问题
        $topic = Topic::find($this->topicId);
        if (!$topic || !empty($topic->slug)) {
            // 若模型不存在，或slug已生成（避免重复处理），直接终止
            \Log::info('TranslateSlug作业：无需处理', ['topic_id' => $this->topicId]);
            return;
        }

        // 正常生成slug的逻辑（示例）
        $topic->slug = Str::slug($topic->title); // 或调用翻译接口
        $topic->save();
    }


}
