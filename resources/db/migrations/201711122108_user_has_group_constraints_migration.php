<?php

use Phinx\Migration\AbstractMigration;

/**
 * Description of UserHasGroupMigration
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2017-11-12 21:13
 */
class UserHasGroupMigration extends AbstractMigration
{
    
    
    /**
     * Migrate Up.
     * addForeignKey
     */
    public function up()
    {
        
        $this->table('user')->addForeignKey('user_status', 'user_status', ['id'],
                            ['constraint'=>'fk_user_status'])->save();
        $this->table('user_details')->addForeignKey('user_id', 'user', ['id'],
                            ['constraint'=>'fk_user_details_user1'])->save();
        $this->table('user_guard')->addForeignKey('user_id', 'user', ['id'],
                            ['constraint'=>'fk_user_guard_user'])->save();
        $this->table('user_has_group')->addForeignKey('user_group', 'user_group', ['id'],
                            ['constraint'=>'fk_user_has_group_group'])->save();
        $this->table('user_has_group')->addForeignKey('user_id', 'user', ['id'],
                            ['constraint'=>'fk_user_has_group_user'])->save();
        $this->table('user_log')->addForeignKey('user_event', 'user_event', ['id'],
                            ['constraint'=>'fk_user_log_event'])->save();
        $this->table('user_log')->addForeignKey('user_id', 'user', ['id'],
                            ['constraint'=>'fk_user_log_user'])->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        
        $this->table('user')->dropForeignKey('user_status')->save();
        $this->table('user_details')->dropForeignKey('user_id')->save();
        $this->table('user_guard')->dropForeignKey('user_id')->save();
        $this->table('user_has_group')->dropForeignKey('user_group')->save();
        $this->table('user_has_group')->dropForeignKey('user_id')->save();
        $this->table('user_log')->dropForeignKey('user_event')->save();
        $this->table('user_log')->dropForeignKey('user_id')->save();
        
    }
}

