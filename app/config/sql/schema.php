<?php 
/* SVN FILE: $Id$ */
/* App schema generated on: 2008-09-24 15:09:54 : 1222240854*/
class AppSchema extends CakeSchema {
    var $name = 'App';

    function before($event = array()) {
        return true;
    }

    function after($event = array()) {
    }

    var $acos = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
        'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
        'alias' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'lft' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
        'rght' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $aros = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
        'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
        'alias' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'lft' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
        'rght' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $aros_acos = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
        'aro_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
        'aco_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
        '_create' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 2),
        '_read' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 2),
        '_update' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 2),
        '_delete' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 2),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'ARO_ACO_KEY' => array('column' => array('aro_id', 'aco_id'), 'unique' => 1))
    ); 
    var $announcements = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $attachments = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'file' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'filename' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'checksum' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'field' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'size' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $comments = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $committees = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
        'short_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'meeting_num_template' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'item_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'minute_template' => array('type' => 'text', 'null' => false, 'default' => NULL),
        'meeting_title_template' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
        'item_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 11),
        'lft' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 11),
        'rght' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 11),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $committeetodos = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
        'priority' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $memberships = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'role_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $decisions = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'meeting_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'item_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'minute_reference' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
        'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'ordering' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'deadline' => array('type' => 'date', 'null' => false, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $decisions_groups = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'decision_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $decisions_users = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'decision_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $groups = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $groupstatuses = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'decision_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'action_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
        'closed' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
        'date_closed' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $hashes = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'url' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255),
        'hash_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'hash' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
        'limit' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'due_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'limit_count' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $items = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
        'short_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $logs = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'targetid' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'controller' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'action' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'url' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'timestamp' => array('type' => 'timestamp', 'null' => false),
        'message' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $meetings = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'meeting_num' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
        'meeting_title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1000),
        'meeting_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'meeting_end_estimate' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'meeting_end' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'allow_representative' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'venue' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
        'agenda' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'minutes' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'invite_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'date', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'date', 'null' => true, 'default' => NULL),
        'minutes_raw' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $meetingtodos = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'meeting_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
        'priority' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
        'done' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'date_done' => array('type' => 'date', 'null' => true, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $attendances = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'meeting_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'will_attend' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'attended' => array('type' => 'integer', 'null' => true, 'default' => '0'),
        'representative' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
        'rep_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
        'excuse' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'att_updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'confirm_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $notifications = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'meeting_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
        'message_title' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'notification_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'notification_sent' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'message' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'to' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $roles = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $settings = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'setting' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'group' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    ); 
    var $templates = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
        'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
        'template' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $titles = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'short_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'long_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $systemtodos = array(
        'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
        'priority' => array('type'=>'integer', 'null' => false, 'default' => NULL),
        'deleted' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $users = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'username' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
        'password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'superuser' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'protocol' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'job_title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'bahagian' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
        'grade' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 80),
        'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
        'telephone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'mobile' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'fax' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
        'address' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'title_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $users_groups = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $userstatuses = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'decision_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'updater' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'action_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
        'closed' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
        'date_closed' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $wfmodels = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'create' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'view' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'edit' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'delete' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'approve' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'disapprove' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $wfstatuses = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'workflow_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'level' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    var $workflows = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'level' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'view' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'edit' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'delete' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'approve' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'disapprove' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
}
?>
