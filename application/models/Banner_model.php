<?php
class Banner_model extends CI_Model {
	public function get_banner_sidebar() {
		$this->db->where('banner', 'sidebar');
		$query = $this->db->get('banners');
		$banner = $query->row();
		if ($banner && $banner->img) {
			return $banner;
		}
		return null;
	}

	public function get_banner_header() {
		$this->db->where('banner', 'header');
		$query = $this->db->get('banners');
		$banner = $query->row();
		if ($banner && $banner->img) {
			return $banner;
		}
		return null;
	}

	public function get_by_ref($ref) {
		$this->db->where('banner', $ref);
		$query = $this->db->get('banners');
		return $query->row();
	}

	public function setbannerimg($banner, $img) {
		$this->db->where('banner', $banner);
		$query = $this->db->get('banners');
		$this->db->set('img', $img);
		if ($query->num_rows()) {
			// Update banner image
			$this->db->where('banner', $banner);
			$this->db->update('banners');
		} else {
			// Insert new banner
			$this->db->set('banner', $banner);
			$this->db->insert('banners');
		}
	}

	public function borrarimg($ref) {
		$this->db->where('banner', $ref);
		$query = $this->db->get('banners');
		if ($query->num_rows()) {
			$banner = $query->row();
			if ($banner->img) {
				unlink(FCPATH . $banner->img);
			}
			// Update banner image
			$this->db->set('img', null);
			$this->db->where('banner', $ref);
			$this->db->update('banners');
		}
	}

	public function setbannerurl($banner, $url) {
		$this->db->where('banner', $banner);
		$query = $this->db->get('banners');
		$this->db->set('url', $url);
		if ($query->num_rows()) {
			// Update banner URL
			$this->db->where('banner', $banner);
			$this->db->update('banners');
		} else if ($url) {
			// Insert banner with URL but no image
			$this->db->set('banner', $banner);
			$this->db->insert('banners');
		}
	}

	public function setbannertarget($banner, $target) {
		// Update banner Target
		$this->db->set('targetblank', $target);
		$this->db->where('banner', $banner);
		$this->db->update('banners');
	}
}
