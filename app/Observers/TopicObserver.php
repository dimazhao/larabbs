<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

 public function saved(Topic $topic)
{
    // 新增：确保模型已存在于数据库（避免事务回滚等极端场景）
    if ($topic->exists && !$topic->slug)
    {
        dispatch(new TranslateSlug($topic->id));
    }
}
}
