<?php
/*
Template Name: Affiliation Request
*/
// error array
$errors = array();
$request = false;
// form submission handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Sanitize and validate form data
	$affiliation_firstname = sanitize_text_field($_POST['affiliation_firstname']);
	$affiliation_lastname = sanitize_text_field($_POST['affiliation_lastname']);
	$affiliation_position = sanitize_text_field($_POST['affiliation_position']);
	$affiliation_bio = wp_kses_post($_POST['affiliation_bio']);
	$affiliation_phone = sanitize_text_field($_POST['affiliation_phone']);
	$affiliation_email = sanitize_email($_POST['affiliation_email']);
	$prefered_contact_method = sanitize_text_field($_POST['prefered_contact_method']);
	$prefered_contact_time = sanitize_text_field($_POST['prefered_contact_time']);
	$affiliation_city = sanitize_text_field($_POST['affiliation_city']);
	$affiliation_province = sanitize_text_field($_POST['affiliation_province']);
	$affiliation_sport = sanitize_text_field($_POST['affiliation_sport']);
	// Validate required fields
	$errors = array();
	if (empty($affiliation_firstname)) {
		$errors[] = 'First name is required.';
	}
	if (empty($affiliation_lastname)) {
		$errors[] = 'Last name is required.';
	}
	if (empty($affiliation_position)) {
		$errors[] = 'Last coaching position is required.';
	}
	if (empty($affiliation_email) || !is_email($affiliation_email)) {
		$errors[] = 'A valid email address is required.';
	}
	if (empty($prefered_contact_method)) {
		$errors[] = 'Preferred contact method is required.';
	}
	if (empty($affiliation_city)) {
		$errors[] = 'City is required.';
	}
	if (empty($affiliation_province)) {
		$errors[] = 'Province is required.';
	}
	if (empty($affiliation_sport)) {
		$errors[] = 'Sport is required.';
	}
	if (empty($errors)) {
		
		//if is multisite, switch to main site
		if (is_multisite()) {
			switch_to_blog(1);
		}

		// create "affiliation" post
		$affiliation_data = array(
			'post_title' => $affiliation_firstname . ' ' . $affiliation_lastname,
			'post_content' => '',
			'post_status' => 'pending',
			'post_type' => 'affiliation',
		);
		$affiliation_id = wp_insert_post($affiliation_data);
		if ($affiliation_id) {
			// update post meta
			update_post_meta($affiliation_id, 'affiliation_firstname', $affiliation_firstname);
			update_post_meta($affiliation_id, 'affiliation_lastname', $affiliation_lastname);
			update_post_meta($affiliation_id, 'affiliation_position', $affiliation_position);
			update_post_meta($affiliation_id, 'affiliation_bio', $affiliation_bio);
			update_post_meta($affiliation_id, 'affiliation_phone', $affiliation_phone);
			update_post_meta($affiliation_id, 'affiliation_email', $affiliation_email);
			update_post_meta($affiliation_id, 'prefered_contact_method', $prefered_contact_method);
			update_post_meta($affiliation_id, 'prefered_contact_time', $prefered_contact_time);
			update_post_meta($affiliation_id, 'affiliation_city', $affiliation_city);
			update_post_meta($affiliation_id, 'affiliation_province', $affiliation_province);
			update_post_meta($affiliation_id, 'affiliation_sport', $affiliation_sport);
		}

		// send HTML email to admin
		$to = 'hello@volleyballwinnipeg.ca';
		$subject = 'New Affiliation Request for ' . $affiliation_city . ' ' . $affiliation_province;
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$message = '<!DOCTYPE html>
					<html>
					<head>
					<meta charset="UTF-8">
					<title>Vision Elite</title>
					</head>
					<body style="margin:0; padding:0; background-color:#f4f4f4;">
					<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding: 20px 0;">
						<tr>
						<td align="center">
							<table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; font-family:Arial, sans-serif;">
							<!-- Header -->
							<tr>
								<td style="background-color:#264898; padding: 20px; text-align:center;">
								<h1 style="color:#ffffff; margin:0; font-size:24px;">Vision Elite</h1>
								</td>
							</tr>

							<!-- Main Message -->
							<tr>
								<td style="padding: 30px; text-align:left;">
									<h2 style="color:#333333; margin-top:0;">Affiliate Program Request for '.$affiliation_city.' '.$affiliation_province.'</h2>
									<p style="color:#555555; line-height:1.5;">
										'.$affiliation_firstname.' '.$affiliation_lastname.' has requested to start a '.$affiliation_sport.' program in '.$affiliation_city.', '.$affiliation_province.'. Below are the details of the request:
									</p>
									<p style="color:#555555; line-height:1.5;">
										<strong>First Name:</strong> ' . esc_html($affiliation_firstname) . '<br>
										<strong>Last Name:</strong> ' . esc_html($affiliation_lastname) . '<br>
										<strong>Last Coaching Position:</strong> ' . esc_html($affiliation_position) . '<br>
										<strong>Bio:</strong><br>' . nl2br(esc_html($affiliation_bio)) . '<br>
										<strong>Phone:</strong> ' . esc_html($affiliation_phone) . '<br>
										<strong>Email:</strong> ' . esc_html($affiliation_email) . '<br>
										<strong>Preferred Contact Method:</strong> ' . esc_html($prefered_contact_method) . '<br>
										<strong>Preferred Contact Time:</strong> ' . esc_html($prefered_contact_time) . '<br>
										<strong>City:</strong> ' . esc_html($affiliation_city) . '<br>
										<strong>Province:</strong> ' . esc_html($affiliation_province) . '<br>
										<strong>Sport:</strong> ' . esc_html($affiliation_sport) . '<br>
									</p>
									<p style="color:#555555; line-height:1.5;">
										A record of this request has been created on the Vision Elite Academy website. You can review the details there.
									</p>
								</td>
							</tr>

							<!-- Call to Action Buttons -->
							<tr>
								<td style="padding: 0 30px 30px; text-align:center;">
									<a href="https://visioneliteacademy.com/admin" style="display:inline-block; padding:12px 24px; background-color:#264898; color:#ffffff; text-decoration:none; border-radius:5px; margin-right:10px;">Log In</a>
								</td>
							</tr>

							<!-- Footer -->
							<tr>
								<td style="background-color:#f4f4f4; padding: 20px; text-align:center; font-size:12px; color:#888888;">
								© Vision Elite. All rights reserved. <br>
								This is a notification email, you have not been added to any mailing lists.
								</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>
					</body>
					</html>';

		// send email
		$sent = wp_mail($to, $subject, $message, $headers);
		if ($sent) {
			// set request to true
			$request = true;
		} else {
			$errors[] = 'There was an error sending your request. Please try again later.';
		}

		// send a confirmation email to the user
		$user_subject = 'Thank You for Your Affiliation Request';
		$user_message = '<!DOCTYPE html>
					<html>
					<head>
					<meta charset="UTF-8">
					<title>Vision Elite</title>
					</head>
					<body style="margin:0; padding:0; background-color:#f4f4f4;">
					<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding: 20px 0;">
						<tr>
						<td align="center">
							<table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; font-family:Arial, sans-serif;">
							<!-- Header -->
							<tr>
								<td style="background-color:#264898; padding: 20px; text-align:center;">
								<h1 style="color:#ffffff; margin:0; font-size:24px;">Vision Elite</h1>
								</td>
							</tr>
							<!-- Main Message -->
							<tr>
								<td style="padding: 30px; text-align:left;">
									<h2 style="color:#333333; margin-top:0;">Thank You for Your Request</h2>
									<p style="color:#555555; line-height:1.5;">
										Thank you for your request to start a '.$affiliation_sport.' program in '.$affiliation_city.', '.$affiliation_province.'. We have received your request and will review it within 5 business days.
									</p>
									<p style="color:#555555; line-height:1.5;">
										We appreciate your interest in bringing high-performance athlete development to your community. Our team will be in touch with you shortly to discuss the next steps.
									</p>
								</td>
							</tr>
							<!-- Call to Action Buttons -->
							<tr>
								<td style="padding: 0 30px 30px; text-align:center;">
									<a href="https://visioneliteacademy.com" style="display:inline-block; padding:12px 24px; background-color:#264898; color:#ffffff; text-decoration:none; border-radius:5px; margin-right:10px;">Visit Our Website</a>
								</td>
							</tr>
							<!-- Footer -->
							<tr>
								<td style="background-color:#f4f4f4; padding: 20px; text-align:center; font-size:12px; color:#888888;">
								© Vision Elite. All rights reserved. <br>
								This is a notification email, you have not been added to any mailing lists.
								</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>
					</body>
					</html>';
		$user_headers = array('Content-Type: text/html; charset=UTF-8');
		wp_mail($affiliation_email, $user_subject, $user_message, $user_headers);

		// if multisite, switch back to current site
		if (is_multisite()) {
			restore_current_blog();
		}
	}
}

get_header();

$user_province = get_user_province();
$user_city = get_user_city();
// get city value from URL parameter
$url_city = isset($_GET['city']) ? ucwords(str_replace('-', ' ', sanitize_text_field($_GET['city']))) : '';
if (!empty($url_city)) {
    $user_city = $url_city;
}
$user_sport = 'volleyball';
// get sport value from URL parameter
$url_sport = isset($_GET['sport']) ? sanitize_text_field($_GET['sport']) : '';
if (!empty($url_sport)) {
    $user_sport = $url_sport;
}


?>

<section id="subsite-top-section" class="template-section province-<?= strtolower($user_province) ?> sport-<?= strtolower($user_sport) ?>">
	<figure class="sport-image">
		<img src="<?=get_template_directory_uri()?>/assets/img/sports/banner-volleyball.png" alt="<?=$user_sport?>" />
	</figure>
	<div class="overlay">
		<div class="container">
			<div class="content">
				<h1><?=$user_city.' '.$user_sport?></h1>
			</div>
		</div>
	</div>
</section>

<section id="subsite-oportunity-section" class="template-section">
	<div class="container">
		<div class="content">
			<h2>Opportunity Awaits</h2>
			<h3>Ready to start your own <?= $user_sport ?> program in <?=($user_city ? $user_city : 'your city')?>? </h3>
            <p>Ready to bring high-performance athlete development to your city? Start your own VISION Elite affiliate program with the full support, resources, and guidance of our proven training system. Whether you're a coach, athlete, or sports leader, this is your opportunity to launch a professional, skill-focused program in your community—backed by a trusted brand with a track record of success in athlete development.</p>
		</div>
	</div>
</section>

<section id="subsite-registration-form-section" class="template-section">
	<div class="container">
        <div class="content">
			<div class="form">
				<h3>Let's serve up success — together.</h3>
				<?php
					// output errors if any
					if (!empty($errors)) {
						echo '<div class="errors">';
						foreach ($errors as $error) {
							echo '<div class="notification error">' . esc_html($error) . '</div>';
						}
						echo '</div>';
					}
					// if request is successful, show success message
					if ($request) {
						echo '<div class="notification success">Thank you for your request! We will review it and get back to you within 5 business days.</div>';
					}
				?>
				<form id="affiliation-request-form" method="post" action="">
					
					<table>
						<tr>
							<td>
								<label for="affiliation_firstname">First Name</label>
								<input type="text" name="affiliation_firstname" id="affiliation_firstname" required />
							</td>
							<td>
								<label for="affiliation_lastname">Last Name</label>
								<input type="text" name="affiliation_lastname" id="affiliation_lastname" required />
							</td>
						</tr>
					</table>

					<label for="affiliation_position">Last Coaching Position</label>
					<input type="text" name="affiliation_position" id="affiliation_position" required />

					<label for="affiliation_bio">Tell Us About Your History</label>
					<?php
						wp_editor('', 'affiliation_bio', array(
							'textarea_name' => 'affiliation_bio',
							'media_buttons' => false,
							'textarea_rows' => 5,
							'teeny' => true,
							'quicktags' => false,
						));
					?>

					<table>
						<tr>
							<td>
								<label for="affiliation_phone">Phone</label>
								<input type="text" name="affiliation_phone" id="affiliation_phone" />
							</td>
							<td>
								<label for="affiliation_email">Email</label>
								<input type="email" name="affiliation_email" id="affiliation_email" required />
							</td>
						</tr>
					</table>

					<label for="prefered_contact_method">Preferred Contact Method</label>
					<select name="prefered_contact_method" id="prefered_contact_method" required>
						<option value="email">Email</option>
						<option value="phone">Phone</option>
						<option value="text">Text</option>
					</select>

					<label for="prefered_contact_time">Preferred Contact Time</label>
					<input type="text" name="prefered_contact_time" id="prefered_contact_time" placeholder="e.g. Weekdays after 5pm" />

					<div class="break"></div>

					<table>
						<tr>
							<td>
								<label for="affiliation_city">City</label>
								<input type="text" name="affiliation_city" id="affiliation_city" value="<?= esc_attr($user_city) ?>" required />
							</td>
							<td>
								<label for="affiliation_province">Province</label>
								<select name="affiliation_province" id="affiliation_province" required>
									<?php
									$provinces = array(
										'AB' => 'Alberta',
										'BC' => 'British Columbia',
										'MB' => 'Manitoba',
										'NB' => 'New Brunswick',
										'NL' => 'Newfoundland and Labrador',
										'NS' => 'Nova Scotia',
										'ON' => 'Ontario',
										'PE' => 'Prince Edward Island',
										'QC' => 'Quebec',
										'SK' => 'Saskatchewan'
									);
									foreach ($provinces as $code => $name) {
										$selected = ($user_province == $code) ? 'selected' : '';
										echo "<option value='$code' $selected>$name</option>";
									}
									?>
								</select>
							</td>
						</tr>
					</table>

					<label for="affiliation_sport">What Sport Would Your Program Run?</label>
					<input type="text" name="affiliation_sport" id="affiliation_sport" value="<?= esc_attr($user_sport) ?>" required />
					
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">Submit Request</button>
					</div>
				</form>
				<p class="form-disclaimer">By submitting this form, you agree to our <a href="<?= esc_url(home_url('/privacy-policy')) ?>">Privacy Policy</a> and <a href="<?= esc_url(home_url('/terms-of-service')) ?>">Terms of Service</a>. We will review your request and get back to you within 5 business days.</p>
			</div>
        </div>
	</div>
</section>

<?php get_footer(); ?>