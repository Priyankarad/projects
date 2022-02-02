<?php
$config = array(
	'school'=>array(
		array(
			'field' => 'school_name',
			'label' => 'School Name',
			'rules' => 'required'
		),
		array(
			'field' => 'email',
			'label' => 'Email Address',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'students',
			'label' => 'Number Of Students',
			'rules' => 'required|numeric'
		),
		array(
			'field' => 'contact_number',
			'label' => 'Contact Number',
			'rules' => 'required|numeric|exact_length[11]'
		),
		array(
			'field' => 'address',
			'label' => 'Address',
			'rules' => 'required'
		),
		array(
			'field' => 'courses[]',
			'label' => 'Courses',
			'rules' => 'required'
		)
	),
	'course'=>array(
		array(
			'field' => 'course_name',
			'label' => 'Course Name',
			'rules' => 'required'
		),
		array(
			'field' => 'duration',
			'label' => 'Course Duration',
			'rules' => 'required|numeric'
		),
		array(
			'field' => 'price',
			'label' => 'Price',
			'rules' => 'required|numeric'
		),
		array(
			'field' => 'schools[]',
			'label' => 'Schools',
			'rules' => 'required'
		)
	)
);