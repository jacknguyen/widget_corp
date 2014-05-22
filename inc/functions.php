<?php
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function find_all_subjects() {
		global $connection;

		$query = "SELECT * ";
		$query .= "FROM subjects ";
		// $query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		return $subject_set;
	}

	function find_pages_for_subjects($subject_id) {
		global  $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE visible = 1 ";
		$query .= "AND subject_id = {$safe_subject_id} ";
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		return $page_set;
	}

	function find_subject_by_id($subject_id) {
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);

		if ($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}

	function find_page_by_id($page_id) {
		global $connection;
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		$query = "SELECT * FROM pages WHERE id = {$safe_page_id} LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);

		if ($page = mysqli_fetch_assoc($page_set)) {
			return $page;
		} else {
			return null;
		}
	}

	function navigation($subject_array, $page_array) {
		$output = "<ul class=\"nav nav-pills nav-stacked\">";
		$subject_set = find_all_subjects();

		while($subject = mysqli_fetch_assoc ($subject_set)) {
			$output .= "<li";
				if($subject_array && $subject_array["id"] == $subject["id"]) {
					$output .= " class=\"active\"";
				}
			$output .= "><a href=\"manage_content.php?subject=";
			$output .= urlencode($subject["id"]);
			$output .= "\"><strong>";
			$output .= htmlentities($subject['menu_name']);
			$output .= "</strong></a>";
			$output .= "<ul class=\"nav nav-pills nav-stacked\">";
			$page_set = find_pages_for_subjects($subject["id"]);
				while($page = mysqli_fetch_assoc ($page_set)) {
					$output .= "<li";
						if($page_array && $page_array["id"] == $page["id"]) {
							$output .= " class=\"active\"";
						}
					$output .= "><a href=\"manage_content.php?page=";
					$output .= urlencode($page["id"]);
					$output .= "\">&nbsp;&nbsp;&nbsp;&nbsp;";
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

	function find_selected() {
		global $current_subject;
		global $current_page;

		if (isset($_GET["subject"])) {
			$current_subject = find_subject_by_id($_GET["subject"]);
			$current_page = null;
			$selected_page_id = null;
		} elseif (isset($_GET["page"])) {
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"]);
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
?>