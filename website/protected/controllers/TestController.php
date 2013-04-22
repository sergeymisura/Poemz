<?php
/**
 * Miscellaneous pages
 * 
 * @package  Canvassing.Controllers
 */
class TestController extends PageController
{
	/**
	 * Main page
	 * 
	 * @return  void
	 */
	public function actionIndex()
	{
		$html = file_get_contents('/mnt/host/temp/sonnets.html');
		$sonnets = explode('<ul><a name', $html);
		for ($i = 2; $i <= 156; $i++) {
			$title = substr($sonnets[$i], strpos($sonnets[$i], '<h2>') + 4);
			$title = substr($title, 0, strpos($title, '</'));
			$text = substr($sonnets[$i], strpos($sonnets[$i], '</ul>') + 5);
			$end = strpos($text, '<');
			if ($end) {
				$text = substr($text, 0, $end);
			}
			$text = trim($text);
			$poem = new Poem();
			$poem->title = $title;
			$poem->submitted_by = 1;
			$poem->author_id = 1;
			$poem->text = $text;
			$poem->save();
		}
		//var_dump($sonnets);
/*		$poem = Poem::model()->findByPk(1);
		$poem->title = 'Sonnet 93';
		$poem->submitted_by = 1;
		$poem->author_id = 1;
		$poem->text = "So shall I live, supposing thou art true,
Like a deceived husband; so love's face
May still seem love to me, though alter'd new;
Thy looks with me, thy heart in other place:
For there can live no hatred in thine eye,
Therefore in that I cannot know thy change.
In many's looks the false heart's history
Is writ in moods and frowns and wrinkles strange,
But heaven in thy creation did decree
That in thy face sweet love should ever dwell;
Whate'er thy thoughts or thy heart's workings be, 
Thy looks should nothing thence but sweetness tell.
   How like Eve's apple doth thy beauty grow,
   If thy sweet virtue answer not thy show!";
		$poem->save();*/
	}
}
