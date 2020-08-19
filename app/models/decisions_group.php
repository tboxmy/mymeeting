<?php
class DecisionsGroup extends AppModel {

/**
 * Defining the name of model
 *
 */
	var $name = 'DecisionsGroup';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * Building assosiations betweeen models
 *
 */
	var $belongsTo = array(
			'Decision' => array('className' => 'Decision',
								'foreignKey' => 'decision_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Group' => array('className' => 'Group',
								'foreignKey' => 'group_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
