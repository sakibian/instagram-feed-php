<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <title>Instagram Feed</title>
</head>
<body>
<div class="container">
  <div class="p-3">
    <h2 class="text-center mt-2 border-left border-right border-primary">
      Displaying images from Instagram
    </h2>
  </div>
  <div class="row row-cols-4">
  <?php
        $fields = "id,media_type,media_url,thumbnail_url,timestamp,permalink,caption";
        $token = "ENTER_YOUR_TOKEN_ID_HERE";
        $limit = 20; // Set a number of display items
          function fetchData($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
          }
          $result = fetchData("https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}");
          $result_decode = json_decode($result, true);

          foreach ($result_decode["data"] as $post) : 
            $permalink = $post["permalink"];
            $media_type = $post["media_type"];
            $caption = (array_key_exists('caption', $post) ? $post['caption'] : null); // If instagram post has no caption it will set to null
            $timestamp = $post['timestamp'];

            if ($media_type == "VIDEO" ) {
              $media_url = $post["thumbnail_url"]; }
            else {
              $media_url = $post["media_url"];
            }


          ?>
          <div class="col mt-5">
            <div class="card">
              <img src="<?php echo $media_url; ?>" class="border-0" alt="<?php echo $caption; ?>">
              <div class="card-body">
                <h6 class="card-title"><?php echo $caption; ?></h6>
                <hr>
                <a href="#" class="card-link"><?php echo $permalink; ?></a>
              </div>
              <div class="card-footer">
                <small class="text-muted float-right"><?php echo date('d-M-Y',strtotime($timestamp)); ?></small>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>