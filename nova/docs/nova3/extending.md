# Extending Nova 3

<pre>public function action\_index()
{
	parent::action\_index();
	
	$this->_data->header = 'My New Header';
}</pre>