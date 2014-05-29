<?php
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function find_all_subjects($public=true) {
		global $connection;

		$query = "SELECT * ";
		$query .= "FROM subjects ";
		if ($public) {
			$query .= "WHERE visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		return $subject_set;
	}

	function find_pages_for_subjects($subject_id, $is_public=true) {
		global  $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE subject_id = {$safe_subject_id} ";
		if ($is_public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		return $page_set;
	}

	function find_subject_by_id($subject_id, $is_public=true) {
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		if ($is_public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);

		if ($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}

	function find_page_by_id($page_id, $is_public=true) {
		global $connection;
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		$query = "SELECT * FROM pages WHERE id = {$safe_page_id} ";
		if ($is_public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);

		if ($page = mysqli_fetch_assoc($page_set)) {
			return $page;
		} else {
			return null;
		}
	}

	function navigation($subject_array, $page_array, $is_public=true) {
		if ($is_public) {
			$url = "index.php";
		} else {
			$url = "manage_content.php";
		}

		$output = '<ul class="nav nav-pills nav-stacked">';
		if(!$is_public) {
			$output .= "<li><a href='admin.php'>";
			$output .= "<span class='glyphicon glyphicon-chevron-left'></span>";
			$output .= "<strong> Admin Menu</strong>";
			$output .= "</a></li>";
		}
		$subject_set = find_all_subjects($is_public);
		while($subject = mysqli_fetch_assoc ($subject_set)) {
			$output .= "<li";
			if($subject_array["id"] == $subject["id"] && !$is_public) {
				$output .= ' class="active"';
			}
			$output .= '><a href="';
			$output .= $url;
			$output .= "?subject=";
			$output .= urlencode($subject["id"]);
			$output .= '"><strong>';
			$output .= htmlentities($subject['menu_name']);
			$output .= "</strong></a>";
			$output .= "<ul class='nav nav-pills nav-stacked ";
			if (!($subject_array["id"] == $subject["id"] || $page_array['subject_id'] == $subject['id']) && $is_public) {
				$output .= 'hidden';
			}
			$output .="'>";
			$page_set = find_pages_for_subjects($subject["id"], $is_public);
			while($page = mysqli_fetch_assoc ($page_set)) {
				$output .= "<li";
				if($page_array["id"] == $page["id"]) {
					$output .= ' class="active"';
				}
				$output .= '><a href=';
				$output .= $url;
				$output .= "?page=";
				$output .= urlencode($page["id"]);
				$output .= '>&nbsp;&nbsp;&nbsp;&nbsp;';
				$output .= htmlentities($page["menu_name"]);
				$output .= "</a></li>";
			}
			mysqli_free_result($page_set);
			$output .= "</ul></li>";
		}
		mysqli_free_result($subject_set);
		$output .= "</ul>";

		return $output;
	}

	function find_default_page_for_subject($subject_id) {
		// for the public area so it will return a first page when a subject is selected
		$page_set = find_pages_for_subjects($subject_id);
		if ($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		} else {
			return null;
		}
	}


	function find_selected($is_public=false) {
		global $current_subject;
		global $current_page;

		if (isset($_GET["subject"])) {
			$current_subject = find_subject_by_id($_GET["subject"], $is_public);
			if ($current_subject && $is_public) {
				$current_page = find_default_page_for_subject($current_subject['id']);
			} else {
				$current_page = null;
			}
			$selected_page_id = null;
		} elseif (isset($_GET["page"])) {
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"], $is_public);
			$selected_subject_id = null;
		} else {
			$current_subject = null;
			$current_page = null;
		}
	}

	function subject_count() {
		global $connection;
		$query = "SELECT COUNT(*) FROM subjects";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		$subject_count = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $subject_count["COUNT(*)"];
	}

	function page_count($subject_id) {
		global $connection;
		$query = "SELECT COUNT(*) FROM pages WHERE subject_id={$subject_id}";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		$page_count = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $page_count["COUNT(*)"];
	}

	function redirect_to($new_location) {
		header("Location: " . $new_location);
		exit;
	}

	function mysql_prep ($string) {
		global $connection;
		$prepared_string = mysqli_real_escape_string($connection, $string);
		return $prepared_string;
	}

	function form_errors($errors) {
		$output = "";
		if (!empty($errors)) {
			foreach ($errors as $key => $error) {
				$output .= htmlentities($error);
				$output .= "<br>";
			}
		}
		$_SESSION["errors"] = null;
		return $output;
	}

	function find_all_admins() {
		global $connection;

		$query = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "ORDER BY user_name ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		return $subject_set;
	}

	function find_admin_by_id($admin_id) {
		global $connection;
		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
		$query = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);

		if ($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function find_admin_by_username($admin_username) {
		global $connection;
		$safe_admin_username = mysqli_real_escape_string($connection, $admin_username);
		$query = "SELECT * FROM admins WHERE user_name = '{$safe_admin_username}' LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);

		if ($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}


	function password_encrypt ($password) {
		$hash_format = "$2y$10$";
		$salt_length = 22;
		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);

		return $hash;
	}

	function generate_salt($length) {
		// mt_rand to get a random value. uniqid will guarantee to get a unique id
		// back and true lets it be a little longer to be more secure
		// which is then passed into the md5 hash
		$unique_random_string = md5(uniqid(mt_rand(), true));

		// Valid characters for a salt are [a-zA-Z0-9./]
		$base64_string = base64_encode($unique_random_string);

		// But no '+' which is valid in base64 encoding
		$modified_base64_string = str_replace('+', '.', $base64_string);

		// Returns the portion of string specified by the start and length parameters.
		$salt = substr($modified_base64_string, 0, $length);

		return $salt;

		// base64 encoding is NOT a way of encrypting, nor a way of compacting data.
		// In fact a base64 encoded piece of data is roughly 1.4 to 1.6 times bigger
		// than the original datapiece. It is only a way to be sure that no data is
		// lost or modified during the transfer.
	}

	function password_check($password, $existing_hash) {
		// taking existing password with existing hash and
		// pulls format and salt from the beginning and uses that as salt
		// for current encryption and checks if the current hash is the same
		// as the hash in the database
		$hash = crypt($password, $existing_hash);
		if ($hash === $existing_hash) {
			return true;
		} else {
			return false;
		}
	}

	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if ($admin) {
			// found admin, check password
			if (password_check($password, $admin['hashed_password'])) {
				// password matches
				return $admin;
			} else {
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}

	function logged_in() {
		return isset($_SESSION['admin_id']);
	}

	function confirm_logged_in() {
		if (!isset($_SESSION['admin_id'])) {
			redirect_to('login');
		}
	}
?>