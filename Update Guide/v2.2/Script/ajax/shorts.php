<?php
if ($first == 'load') {
	$html = '';
	$data['status'] = 400;
	if (!empty($_COOKIE['shorts'])) {
		$saved_ids = json_decode($_COOKIE['shorts']);
		$pt->video_240 = 0;
		$pt->video_360 = 0;
		$pt->video_480 = 0;
		$pt->video_720 = 0;
		$pt->video_1080 = 0;
		$pt->video_2048 = 0;
		$pt->video_4096 = 0;
		$pt->is_empty = false;
		if (!empty($saved_ids)) {
			if (!empty($_POST['history']) && is_numeric($_POST['history']) && $_POST['history'] > 0) {
				if ($pt->config->history_system == 'on' && IS_LOGGED == true && $pt->user->pause_history == 0) {
					$history = PT_Secure($_POST['history']);
			        $is_in_history = $db->where('video_id', $history)->where('user_id', $user->id)->getValue(T_HISTORY, 'count(*)');
			        if ($is_in_history == 0) {
			            $insert_to_history = array(
			                'user_id' => $user->id,
			                'video_id' => $history,
			                'time' => time()
			            );
			            $insert_to_history_query = $db->insert(T_HISTORY, $insert_to_history);
			        }
			    }
			}
			if (!empty($_POST['order']) && $_POST['order'] == 'id' && !empty($_POST['video_id']) && is_numeric($_POST['video_id']) && $_POST['video_id'] > 0) {
				$videos = $db->where('privacy', 0)->where('approved',1)->where('user_id',$pt->blocked_array , 'NOT IN')->where('is_short',1)->where('id',$saved_ids,'NOT IN')->where('id',PT_Secure($_POST['video_id']),'<')->orderBy('id','DESC')->get(T_VIDEOS,5);
			}
			else{
				$videos = $db->where('privacy', 0)->where('approved',1)->where('user_id',$pt->blocked_array , 'NOT IN')->where('is_short',1)->where('id',$saved_ids,'NOT IN')->where('time',time() - (60 * 60),'>')->orderBy('views','DESC')->get(T_VIDEOS,5);
				if (empty($videos)) {
					$videos = $db->where('privacy', 0)->where('approved',1)->where('user_id',$pt->blocked_array , 'NOT IN')->where('is_short',1)->where('id',$saved_ids,'NOT IN')->orderBy('id','DESC')->get(T_VIDEOS,5);
				}
			}

			if (!empty($videos)) {
				$data['status'] = 200;
				foreach ($videos as $key => $value) {
					$saved_ids[] = $value->id;
					$get_video = PT_GetVideoByID($value->video_id, 1, 1);
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
					$pt->is_first_video = false;
					$pt->converted   = true;
					if ($pt->config->ffmpeg_system == 'on' && $get_video->converted != 1) {
					    $pt->converted = false;
					}
					$pt->is_first_video = false;
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
				setcookie('shorts', json_encode($saved_ids), time()+(60 * 60),'/');
			}
		}
	}
	$data['html'] = $html;
}