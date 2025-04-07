<?php

namespace app\event;

use think\facade\Db;

class getAllCategories
{
    public function handle()
    {
        $categories = Db::name("article_categories")->select();
        return $categories;
    }
}