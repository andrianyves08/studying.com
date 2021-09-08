<?php
	class Blog_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

	public function get_blogs($id = FALSE){
		$this->db->select('*, blog.id as blog_ID, blog.status as blog_status');
    	$this->db->join('admin', 'admin.id = blog.admin_ID');
		if($id === FALSE){
			$query = $this->db->get('blog');;
			return $query->result_array();
		}

		$query = $this->db->get_where('blog', array('blog.id' => $id));

		return $query->row_array();
	}

	public function get_category($category_ID = FALSE){
		$this->db->select('category.*, category_type.name as type_name');
		$this->db->join('category_type', 'category_type.id = category.type');
		if($category_ID === FALSE){
			$query = $this->db->get('category');;
			return $query->result_array();
		}

		if(is_numeric($category_ID) == 1){
			$query = $this->db->get_where('category', array('id' => $category_ID));
		} else {
			$query = $this->db->get_where('category', array('slug' => $category_ID));
		}
		return $query->row_array();
	}

	public function get_blog_to_categories($blog_ID = FALSE){
		$this->db->select('category.name, category.id');
		$this->db->join('category', 'blog_to_category.category_ID = category.id');
		$this->db->where('blog_to_category.blog_ID', $blog_ID);

		$query = $this->db->get('blog_to_category');

		return $query->result_array();
	}

	public function get_files($id){
    	$query = $this->db->get_where('blog_file', array('blog_ID' => $id));
		return $query->result_array();
	}

	public function get_type($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('blog_type');;
			return $query->result_array();
		}

		$query = $this->db->get_where('blog_type', array('id' => $id));

		return $query->row_array();
	}

	public function create_blog($title, $meta_description, $banner, $content, $category, $meta_keywords, $files, $admin_ID){
		$this->db->trans_begin();

		$slug = url_title($title);

		$data = array(
			'title' => $title,
			'description' => $meta_description,
			'slug' => strtolower($slug),
			'type' => '1',
			'banner' => $banner,
			'content' => $content,
			'meta_description' => strtolower($meta_description),
			'meta_keywords' => strtolower($meta_keywords),
			'admin_ID' => $admin_ID
		);

		$this->db->insert('blog', $data);
		$blog_ID = $this->db->insert_id();
		
		$this->add_category($category, $blog_ID);

		if(!empty($files)){
			$sql = $this->upload_file($files, $blog_ID);
			if(!$sql){
				return false;
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function create_category($name, $admin_ID){
		$this->db->trans_begin();

		$slug = url_title($name);

		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
			'type' => '2',
			'admin_ID' => $admin_ID
		);

		$this->db->insert('category', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function add_category($category, $blog_ID){
		$this->db->trans_begin();

		for($i=0; $i<count($category); $i++) {
			if(trim($category[$i] != '')) {
		        $category_ID = $category[$i];

		        $data2 = array(
					'blog_ID' => $blog_ID,
					'category_ID' => $category_ID
				);
				$this->db->insert('blog_to_category', $data2);
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function upload_file($files, $blog_ID){
		$this->db->trans_begin();

		$total_files = count($files);
		for($i=0; $i<$total_files; $i++) {
			if(trim($files[$i] != '')) {
		        $file = $files[$i];
		        $data = array(
		        	'file' => $file,
					'blog_ID' => $blog_ID
				);
				$this->db->insert('blog_file', $data);
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_files($blog_ID){
		$this->db->trans_begin();
		
		$this->db->delete('blog_file', array('blog_ID' => $blog_ID));
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_blog($blog_ID, $title, $meta_description, $banner, $content, $category, $meta_keywords, $files, $admin_ID){
		$this->db->trans_begin();
		$slug = url_title($title);

		$data = array(
			'title' => $title,
			'description' => $meta_description,
			'slug' => strtolower($slug),
			'banner' => $banner,
			'content' => $content,
			'meta_description' => strtolower($meta_description),
			'meta_keywords' => strtolower($meta_keywords),
			'admin_ID' => $admin_ID,
		);

		$this->db->set('timestamp', 'NOW()', FALSE);
		$this->db->where('id', $blog_ID);
		$this->db->update('blog', $data);

		$this->db->delete('blog_to_category', array('blog_ID' => $blog_ID));
		$this->add_category($category, $blog_ID);

		if(!empty($files)){
			$this->db->delete('blog_file', array('blog_ID' => $blog_ID));
			$sql = $this->upload_file($files, $blog_ID);
			if(!$sql){
				return false;
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function search_blog($search, $limit, $start){
		$this->db->select('*');
		$this->db->like('title', $search);
		$this->db->or_like('description', $search);
		$this->db->or_like('content', $search);
		$this->db->where('status', '1');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$query = $this->db->get('blog');

		return $query->result_array();
	}

	public function delete_blog($id){
		$this->db->set('status', '0');
		$this->db->where('id', $id);
		$this->db->update('blog');
	}

	public function restore_blog($id){
		$this->db->set('status', '1');
		$this->db->where('id', $id);
		$this->db->update('blog');
	}
}