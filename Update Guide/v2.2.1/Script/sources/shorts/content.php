<?php
$id = '';
$add_ids = false;
$order = 'views';
if (empty($_GET['id'])) {
	$get_video = $db->where('privacy', 0)->where('approved',1)->where('user_id',$pt->blocked_array , 'NOT IN')->where('is_short',1)->where('time',time() - (60 * 60),'>')->orderBy('views','DESC')->getOne(T_VIDEOS);
	if (empty($get_video)) {
		$order = 'id';
		$get_video = $db->where('privacy', 0)->where('approved',1)->where('user_id',$pt->blocked_array , 'NOT IN')->where('is_short',1)->orderBy('id','DESC')->getOne(T_VIDEOS);
	}
	if (!empty($get_video)) {
		$id = $get_video->video_id;
		unset($_COOKIE['shorts']);
        setcookie('shorts', null, -1,'/');
        $add_ids = true;
	}
}

if (!empty($_GET['id'])) {
	$order = 'id';
	$id = PT_Secure($_GET['id']);
	if (strpos($id, '_') !== false) {
	    $id_array = explode('_', $id);
	    $id_html  = $id_array[1];
	    $id       = str_replace('.html', '', $id_html);
	    $id = PT_Secure($id);
	    unset($_COOKIE['shorts']);
        setcookie('shorts', null, -1,'/');
        $add_ids = true;
	}
}
$html = '';
$pt->video_240 = 0;
$pt->video_360 = 0;
$pt->video_480 = 0;
$pt->video_720 = 0;
$pt->video_1080 = 0;
$pt->video_2048 = 0;
$pt->video_4096 = 0;
$pt->is_empty = false;
$shorts_ids = array();
if (!empty($id)) {
	$all_videos = array();
	$video = PT_GetVideoByID($id, 1, 1);
	if (!empty($video)) {
		if (!empty($_GET['id'])) {
			if ($video->privacy == 1) {
			    if (!IS_LOGGED) {
			        header("Location: " . PT_Link('shorts'));
    				exit();
			    } else if (($video->user_id != $pt->user->id) && ($pt->user->admin == 0)) {
			        header("Location: " . PT_Link('shorts'));
    				exit();
			    }
			}
		}
		if ($pt->config->history_system == 'on' && IS_LOGGED == true && $user->pause_history == 0) {
	        $is_in_history = $db->where('video_id', $video->id)->where('user_id', $user->id)->getValue(T_HISTORY, 'count(*)');
	        if ($is_in_history == 0) {
	            $insert_to_history = array(
	                'user_id' => $user->id,
	                'video_id' => $video->id,
	                'time' => time()
	            );
	            $insert_to_history_query = $db->insert(T_HISTORY, $insert_to_history);
	        }
	    }

		if ($add_ids) {
			$shorts_ids[] = $video->id;
		}
		$video->url                = PT_Link('shorts/' . $video->video_id);
		if ($pt->config->seo_link == 'on') {
		    $video->url                = PT_Link('shorts/' . PT_Slug($video->title, $video->video_id));
		}
		$pt->page_url_ = $video->url;
		$all_videos[] = $video;
		if (!empty($_COOKIE['shorts'])) {
			$saved_ids = json_decode($_COOKIE['shorts']);
			if (!empty($saved_ids) && in_array($video->id, $saved_ids)) {
				$currentkey = array_search ($video->id, $saved_ids);
				for ($i=$currentkey + 1; $i < count($saved_ids); $i++) {
					if (!empty($saved_ids[$i]) && is_numeric($saved_ids[$i])) {
						$video = PT_GetVideoByID($saved_ids[$i], 1, 1,2);
						if (!empty($video)) {
							$all_videos[] = $video;
						}
					}
				}
			}
		}
		if (count($all_videos) == 1) {

			if ($order == 'views') {
				$videos = $db->where('is_short',1)->where('id',$video->id,'<>')->where('privacy',0)->where('approved',1)->where('user_id',$pt->blocked_array , 'NOT IN')->where('time',time() - (60 * 60),'>')->orderBy('views','DESC')->get(T_VIDEOS,5);
				if (empty($videos)) {
					$videos = $db->where('is_short',1)->where('id',$video->id,'<>')->where('privacy',0)->where('approved',1)->where('user_id',$pt->blocked_array , 'NOT IN')->orderBy('id','DESC')->get(T_VIDEOS,5);
				}
			}
			else{
				$videos = $db->where('is_short',1)->where('id',$video->id,'<')->where('privacy',0)->where('approved',1)->where('user_id',$pt->blocked_array , 'NOT IN')->orderBy('id','DESC')->get(T_VIDEOS,5);
			}
			if (!empty($videos)) {
				foreach ($videos as $key => $value) {
					$video = PT_GetVideoByID($value->video_id, 1, 1);
					if (!empty($video)) {
						$all_videos[] = $video;
						if ($add_ids) {
							$shorts_ids[] = $video->id;
						}
					}
				}
			}
		}


		if (!empty($shorts_ids)) {
			setcookie('shorts', json_encode($shorts_ids), time()+(60 * 60),'/');
		}

		foreach ($all_videos as $key => $get_video) {
			$pt->video_240 = 0;
			$pt->video_360 = 0;
			$pt->video_480 = 0;
			$pt->video_720 = 0;
			$pt->video_1080 = 0;
			$pt->video_2048 = 0;
			$pt->video_4096 = 0;
			if ($pt->config->ffmpeg_system == 'on') {
				$explode_video = explode('_video', $get_video->video_location);
				if ($get_video->{"240p"} == 1) {
			        $pt->video_240 = $explode_video[0] . '_video_shorts_240p_converted.mp4';
			    }
			    if ($get_video->{"360p"} == 1) {
			        $pt->video_360 = $explode_video[0] . '_video_shorts_360p_converted.mp4';
			    }
			    if ($get_video->{"480p"} == 1) {
			        $pt->video_480 = $explode_video[0] . '_video_shorts_480p_converted.mp4';
			    }
			    if ($get_video->{"720p"} == 1) {
			        $pt->video_720 = $explode_video[0] . '_video_shorts_720p_converted.mp4';
			    }
			    if ($get_video->{"1080p"} == 1) {
			        $pt->video_1080 = $explode_video[0] . '_video_shorts_1080p_converted.mp4';
			    }
			    if ($get_video->{"4096p"} == 1) {
			        $pt->video_4096 = $explode_video[0] . '_video_shorts_4096p_converted.mp4';
			    }
			    if ($get_video->{"2048p"} == 1) {
			        $pt->video_2048 = $explode_video[0] . '_video_shorts_2048p_converted.mp4';
			    }
			}
			$video_type = 'video/mp4';
			$get_video->url                = PT_Link('shorts/' . $get_video->video_id);
			if ($pt->config->seo_link == 'on') {
			    $get_video->url                = PT_Link('shorts/' . PT_Slug($get_video->title, $get_video->video_id));
			}
			$pt->count_comments  = $db->where('video_id', $get_video->id)->where('user_id',$pt->blocked_array , 'NOT IN')->getValue(T_COMMENTS, 'count(*)');
			$pt->get_video = $get_video;
			$pt->converted   = true;
			if ($pt->config->ffmpeg_system == 'on' && $get_video->converted != 1) {
			    $pt->converted = false;
			}
			$pt->is_first_video = false;
			if ($key == 0 && !$pt->is_ajax_load) {
				$pt->is_first_video = true;
			}
			$html  .= PT_LoadPage('shorts/list', array(
									    'ID' => $get_video->id,
									    'KEY' => $get_video->video_id,
									    'THUMBNAIL' => $get_video->thumbnail,
									    'TITLE' => $get_video->title,
									    'DESC' => $get_video->markup_description,
									    'URL' => $get_video->url,
									    'VIDEO_TYPE' => $video_type,
									    'VIDEO_LOCATION_240' => $pt->video_240,
									    'VIDEO_LOCATION' => $get_video->video_location,
									    'VIDEO_LOCATION_360' => $pt->video_360,
									    'VIDEO_LOCATION_480' => $pt->video_480,
									    'VIDEO_LOCATION_720' => $pt->video_720,
									    'VIDEO_LOCATION_1080' => $pt->video_1080,
									    'VIDEO_LOCATION_4096' => $pt->video_4096,
									    'VIDEO_LOCATION_2048' => $pt->video_2048,
									    'VIDEO_MAIN_ID' => $get_video->video_id,
									    'VIDEO_MAIN_ID' => $get_video->video_id,
									    'VIDEO_ID' => $get_video->video_id_,
									    'LIKES' => number_format($get_video->likes),
									    'DISLIKES' => number_format($get_video->dislikes),
									    'COUNT_COMMENTS' => $pt->count_comments,
									    'USER_DATA' => $get_video->owner,
									    'LIKE_ACTIVE_CLASS' => ($get_video->is_liked > 0) ? 'active' : '',
									    'DIS_ACTIVE_CLASS' => ($get_video->is_disliked > 0) ? 'active' : '',
									    'RAEL_LIKES' => $get_video->likes,
									    'RAEL_DISLIKES' => $get_video->dislikes,
									    'ISLIKED' => ($get_video->is_liked > 0) ? 'liked="true"' : '',
									    'ISDISLIKED' => ($get_video->is_disliked > 0) ? 'disliked="true"' : '',
									    'VIEWS' => number_format($get_video->views),));
		}
	}
}
if (empty($html)) {
	$pt->is_empty = true;
	$html = '<div class="text-center no-comments-found empty_state"><svg class="feather" width="24" height="24" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 98.94 122.88" xml:space="preserve"><g><path fill="currentColor" class="st0" d="M63.49,2.71c11.59-6.04,25.94-1.64,32.04,9.83c6.1,11.47,1.65,25.66-9.94,31.7l-9.53,5.01 c8.21,0.3,16.04,4.81,20.14,12.52c6.1,11.47,1.66,25.66-9.94,31.7l-50.82,26.7c-11.59,6.04-25.94,1.64-32.04-9.83 c-6.1-11.47-1.65-25.66,9.94-31.7l9.53-5.01c-8.21-0.3-16.04-4.81-20.14-12.52c-6.1-11.47-1.65-25.66,9.94-31.7L63.49,2.71 L63.49,2.71z M36.06,42.53l30.76,18.99l-30.76,18.9V42.53L36.06,42.53z"></path></g></svg>'.$pt->all_lang->no_videos_found_for_now.'</div>';
	$pt->page_url_ = PT_Link('shorts');
}

$pt->order = $order;

$pt->page = $page = 'shorts';
$pt->title = (!empty($get_video) && !empty($get_video->title) ? $get_video->title : $pt->config->title);
$pt->description = $pt->config->description;
$pt->keyword     = @$pt->config->keyword;
$pt->content  = PT_LoadPage('shorts/content', array('HTML' => $html));
