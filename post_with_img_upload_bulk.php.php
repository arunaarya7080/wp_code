<?php
if (isset($_GET["upload_img"]) && $_GET["upload_img"] == 'upload_client') {
         
         function create_client_posts_from_images() {
         // Specify the folder containing the images
         $folder = get_template_directory() . '/client_img_folder';
         
         // Get all image files from the folder
         $images = glob($folder . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
         
         if (empty($images)) {
             return 'No images found in the folder.'; // Return message if no images found
         }
     
         $success_count = 0; // Initialize success counter
     
         // Loop through each image and create a post for each
         foreach ($images as $image_path) {
             // Get the image name without extension
             $image_name = pathinfo($image_path, PATHINFO_FILENAME);
     
             // Create a new post with the image name as the title
             $postarr = array(
                 'post_title'   => $image_name,
                 'post_content' => '',
                 'post_type'    => 'client',
                 'post_status'  => 'publish',
             );
             $post_id = wp_insert_post($postarr);
     
             if (!is_wp_error($post_id)) {
                 // Upload the image to the media library and attach to the post
                 $attachment_id = upload_image_to_media_library($image_path, $post_id);
     
                 if ($attachment_id) {
                     // Set the uploaded image as the featured image
                     set_post_thumbnail($post_id, $attachment_id);
                     $success_count++;
                 }
             }
         }
     
         if ($success_count == count($images)) {
             return 'All images uploaded successfully and posts created.';
         } else {
             return 'Some images failed to upload or create posts.';
         }
     }
     
     function upload_image_to_media_library($image_path, $post_id) {
         $file_type = wp_check_filetype(basename($image_path), null);
         $attachment = array(
             'post_mime_type' => $file_type['type'],
             'post_title'     => sanitize_file_name(basename($image_path)),
             'post_content'   => '',
             'post_status'    => 'inherit',
         );
     
         // Move the file to the uploads directory
         $upload = wp_upload_bits(basename($image_path), null, file_get_contents($image_path));
     
         if ($upload['error']) {
             return false;
         }
     
         // Insert the attachment into the media library
         $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
         require_once(ABSPATH . 'wp-admin/includes/image.php');
         $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
         wp_update_attachment_metadata($attach_id, $attach_data);
     
         return $attach_id;
     }
     
     // Hook the function to an action or call it directly
     $result = create_client_posts_from_images();
     echo $result; // Output the result message
     echo '<br>';
     echo 'upload success';
     
}

?>