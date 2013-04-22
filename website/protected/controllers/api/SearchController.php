<?php 

class SearchController extends ApiController
{
	public function actionAuthor() {
		$q = strtolower($this->request->getParam('q', ''));
		if ($q == '') {
			$this->send(array());
		}
		$words = array();
		$cond = array();
		if (preg_match_all("/[a-z']+/", $q, $words))
		{
			foreach($words[0] as $word)
			{
				$cond[] = "aft.word like '" . $word . "%'";
			}
		}
		$command = Yii::app()->db->createCommand(
			'select a.id, a.name, sum(aft.weight) weight 
				from author_fulltext aft left join author a on a.id = aft.author_id
				where (' . implode(' or ', $cond) . ')
				group by a.id
				order by weight desc limit 10');
		$this->send($command->queryAll(true, array(':like' => $q . '%')));
	}

	public function actionPoem() {
			$q = strtolower($this->request->getParam('q', ''));
		if ($q == '') {
			$this->send(array());
		}
		$words = array();
		$cond = array();
		if (preg_match_all("/[a-z']+/", $q, $words))
		{
			foreach($words[0] as $word)
			{
				$cond[] = "pft.word like '" . $word . "%'";
			}
		}
		$command = Yii::app()->db->createCommand(
				'select p.id, p.title, p.first_line, sum(pft.weight) weight, p.author_id, a.name author_name 
				from poem_fulltext pft left join poem p on p.id = pft.poem_id left join author a on a.id = p.author_id
				where (' . implode(' or ', $cond) . ')
				group by p.id
				order by weight desc limit 10');
		$this->send($command->queryAll(true, array(':like' => $q . '%')));
	}
}
