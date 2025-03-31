<?php
use think\migration\Migrator;
use think\migration\db\Column;

class CreateUserInfoTable extends Migrator
{
    public function change()
    {
        $this->table('user_info')
            ->addColumn('user_id', 'integer', ['comment' => '用户ID'])
            ->addColumn('ip', 'string', ['limit' => 45, 'comment' => 'IP地址'])
            ->addColumn('userAgent', 'string', ['limit' => 255, 'comment' => '用户代理'])
            ->addColumn('language', 'string', ['limit' => 10, 'comment' => '首选语言'])
            ->addColumn('agreement_accepted', 'boolean', ['default' => false, 'comment' => '是否同意协议'])
            ->addColumn('agreement_accepted_at', 'datetime', ['null' => true, 'comment' => '协议同意时间'])
            ->addColumn('created_at', 'datetime', ['null' => true, 'comment' => '创建时间'])
            ->addColumn('updated_at', 'datetime', ['null' => true, 'comment' => '更新时间'])
            ->addIndex(['user_id'], ['name' => 'idx_user_id'])
            ->addIndex(['ip'], ['name' => 'idx_ip'])
            ->addIndex(['created_at'], ['name' => 'idx_created_at'])
            ->addIndex(['agreement_accepted'], ['name' => 'idx_agreement_accepted'])
            ->create();
    }
} 