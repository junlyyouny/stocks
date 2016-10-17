<?php
/**
 * 示例
 */
class ItemsController extends Controller {
	function view($id = null,$name = null) {
		$this->set('title',$name.' - My Todo List App');
		$this->set('todo',$this->Item->select($id));
		$this->template();
	}

	function viewall() {
		$this->set('title','All Items - My Todo List App');
		$this->set('todo',$this->Item->selectAll());
		$this->template();
	}

	function add() {
		$todo = $_POST['todo'];
		$this->set('title','Success - My Todo List App');
		$this->set('todo',$this->Item->query('insert into items (item_name) values (\''.mysql_real_escape_string($todo).'\')'));
		$this->template();
	}

	function delete($id) {
		$this->set('title','Success - My Todo List App');
		$this->set('todo',$this->Item->query('delete from items where id = \''.mysql_real_escape_string($id).'\''));
		$this->template();
	}
}