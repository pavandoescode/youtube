<html>
<head>
  <title><?php echo $title; ?></title>
  <style>
    /* Add some basic styling to make the page look better */
    .container {
      width: 50%;
      margin: 0 auto;
      text-align: center;
    }
    input[type="text"], input[type="submit"] {
      padding: 10px;
      margin: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>YouTube Video View Calculator</h1>
    <form action="" method="post">
      <!-- Input fields for video ID and minutes -->
      <input type="text" name="video_id" placeholder="Enter video ID">
      <input type="text" name="minutes" placeholder="Enter minutes">
      <!-- Submit button -->
      <input type="submit" name="submit" value="Calculate">
    </form>
    <?php
      if (isset($_POST['submit'])) {
        // Get the video ID and minutes from the form
        $video_id = $_POST['video_id'];
        $minutes = $_POST['minutes'];
        
        // YouTube Data API endpoint for getting the video information
        $api_endpoint = 'https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics&id=' . $video_id . '&key=' . "AIzaSyB4fw2hMRGwI9SRLMtatcZOUko43YU6FXQ";
        
        // Get the video information using curl
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => $api_endpoint
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        // Decode the JSON response into an array
        $video_data = json_decode($response, true);
        
        // Get the number of views and the published date of the video
        $views = $video_data['items'][0]['statistics']['viewCount'];
        $published_date = $video_data['items'][0]['snippet']['publishedAt'];


        $title = $video_data['items'][0]['snippet']['title'];


        // Calculate the estimated views after x minutes
        $views_per_minute = $views / ((time() - strtotime($published_date)) / 60);
        $estimated_views = $views + ($views_per_minute * $minutes);
        
echo $title;

        // Display the estimated views with commas
        echo '<h2>Estimated Views After ' . $minutes . ' Minutes: ' . number_format(round($estimated_views)) . '</h2>';
      }
    ?>
  </div>
</body>
</html>
