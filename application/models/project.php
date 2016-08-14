<?php
class Project extends CI_Model  {

	// attributes

	public function Project()
	{
		parent::__construct();
		// Load  models here

		// Load libraries here

	} // end constructor

	public function add_project ($package)
	{
		$this->db->insert('projects', $package);
	}

	public function get_projects ($enabled=false)
	{
		$result = new stdClass();
		$result->success = false;
		$result->msg = '';
		$result->rows = array();

		// Get project meta
		$this->db->order_by('project_year desc, order asc');
		if ( $enabled )
			$this->db->where('is_enabled', '1');
		$query = $this->db->get('projects');

		if ( $query->num_rows() < 1 )
		{
			$result->success = false;
			$result->msg = 'No rows were acquired.';
			return $result;
		}

		$result->rows = $query->result();

		// Transform data to readable output
		$sortedProjects = array();
		foreach ( $result->rows as $row )
		{
			$id = $row->id;
			// Set up project's textarea brief
			$row->textarea = str_replace('<br />', '', $row->project_brief);
			// Set up project galleries
			$row->galleries = array();
			// Get galleries for the project
			$gQuery = $this->db->get_where('project_galleries', array('project_id' => $id));
			if ( $gQuery->num_rows() > 0 )
				$row->galleries = $gQuery->result();

			foreach ($row->galleries as $key => $image)
			{
				$imageQ = $this->db->get_where('gallery', array('id' => $image->gallery_id));
				$image->image_data = array();
				$imageQRows = $imageQ->result();
				if ( $imageQ->num_rows() > 0 )
					$image->image_data = $imageQRows[0];

				if( $image->is_default )
					$row->default_image = $image;
			}

			if ( !isset ( $row->default_image ) )
			{
				$row->default_image = array();
				foreach ( $row->galleries as $image )
				{
					$row->default_image = $image;
					break;
				}
			}

			if ( !isset ( $sortedProjects[$row->project_year] ) )
				$sortedProjects[$row->project_year] = array();
			array_push($sortedProjects[$row->project_year], $row);
		}

		$result->rows = $sortedProjects;
		$result->success = true;
		return $result;
	}

	public function update_project($package)
	{
		$this->db->where('id', $package['id']);
		unset($package['id']);
		$this->db->update('projects', $package);
	}

	public function get_gallery( )
	{
		$result = new stdClass();
		$result->success = false;
		$result->rows = array();

		$query = $this->db->get('gallery');	
		if ( $query->num_rows() < 1 )
			return $result;

		$result->rows = $query->result();
		$result->success = true;
		return $result;
	}

	public function get_project_gallery($project_id)
	{
		$result = new stdClass();
		$result->success = false;
		$result->rows = array();

		$this->db->order_by('is_default desc');
		$query = $this->db->get_where('project_galleries', array('project_id' => $project_id));
		if ( $query->num_rows() < 1 )
			return $result;

		$result->rows = $query->result();

		foreach ( $result->rows as $row ) 
		{
			// get the gallery pictures
			$gQuery = $this->db->get_where('gallery', array('id' => $row->gallery_id));
			$gQueryRows = $gQuery->result();
			if ( $gQuery->num_rows > 0 )
				$row->image_data = $gQueryRows[0];
		}

		$result->success = true;
		return $result;
	}

	public function get_project_brief($project_id)
	{
		$result = new stdClass();
		$result->success = false;
		$result->rows = array();

		$this->db->limit(1);
		$query = $this->db->get_where('projects', array('id' => $project_id));
		if ( $query->num_rows() < 1 )
			return $result;

		$queryRows = $query->result();
		$result->data = $queryRows[0]->project_brief;

		$result->success = true;
		return $result;
	}

	public function remove_image( $image_id )
	{
		$this->load->helper('file');

		$query = $this->db->get_where('gallery', array('id' => $image_id));
		if ( ($query->num_rows() > 0) == false )
			return false;

		$queryRows = $query->result();
		unlink( './uploaded_content/images/gallery/' . $queryRows[0]->image_path );

		$this->db->where('id', $image_id);
		$this->db->delete('gallery');

		$this->db->where('gallery_id', $image_id);
		$this->db->delete('project_galleries');
	}

	public function remove_project_image( $gallery_id, $project_id )
	{
		$this->db->where(array('id' => $gallery_id, 'project_id' => $project_id));
		$this->db->delete('project_galleries');
	}

	public function add_image_to_project( $image_id, $project_id )
	{
		$this->db->insert('project_galleries', array('gallery_id' => $image_id, 'project_id' => $project_id));
	}

	public function add_image_to_project_default( $image_id, $project_id )
	{
		//Reset all defaults
		$this->db->where('project_id', $project_id);
		$this->db->update('project_galleries', array('is_default' => 0));

		// Insert new image and make default
		$this->db->insert('project_galleries', array('gallery_id' => $image_id, 'project_id' => $project_id, 'is_default' => 1));

	}

	public function image_project_default( $image_id, $project_id )
	{
		//Reset all defaults
		$this->db->where('project_id', $project_id);
		$this->db->update('project_galleries', array('is_default' => 0));

		// Insert new image and make default
		$this->db->limit(1);
		$this->db->where(array('project_id' => $project_id, 'gallery_id' => $image_id));
		$this->db->update('project_galleries', array('is_default' => 1));

	}

} // end class
?>