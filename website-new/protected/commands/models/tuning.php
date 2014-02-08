<?php

return array(
	'aliases' => array(
		'prerequisite.course_id' => 'required_for',
		'activity.unit_id' => 'activities',
		'quiz_variant.quiz_id' => 'variants',
		'quiz_problem.variant_id' => 'problems',
		'quiz_answer.problem_id' => 'answers',
		'quiz_answer_match.answer_id' => 'match',
		'taxon.taxonomy_id' => 'taxa',
		'taxon.parent_id' => 'children',
		'course.author_id' => 'author_of',
		'course.instructor_id' => 'instructor_of'
	),
	'ignore' => array(
		'Content.documents',
		'ActivityType.activitys'
	)
);
