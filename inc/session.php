<?php
	session_start();

	function message() {
		if (isset($_SESSION["message"])) {
			$message = "<br><p class=\"bg-info\">";
			$message .= htmlentities($_SESSION["message"]);
			$message .= "</p>";
			$_SESSION["message"] = null;
			return $message;
		}
	}

	function errors() {
		if (isset($_SESSION["errors"])) {
			$errors = "<br><p class=\"bg-danger\">";
			$errors .= htmlentities($_SESSION["errors"]);
			$errors .= "</p>";

			$_SESSION["errors"] = null;
			return $errors;
		}
	}

?>