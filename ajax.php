<?php 
error_reporting( E_ALL );

$action = $_POST['action'];

function get_file() {
	$file = getcwd() . "/data.json";

	return $file;
}

function get_content() {
	$file = get_file();

	$jsonList = file_get_contents($file);
	$list  = json_decode($jsonList);
	date_default_timezone_set('Europe/London');
	//date_default_timezone_set('Asia/Kolkata');
	foreach ($list as $key => $record) {
		if(array_key_exists('dateTime', $record)){
			$list[$key]->niceDate = date('M d, h.i a', strtotime( $record->dateTime ));
			$list[$key]->messageDate = date('D M d Y,', strtotime( $record->dateTime ))." at ".date('h:i a', strtotime( $record->dateTime ));
			$list[$key]->diffrence =  strtotime($record->dateTime) - strtotime(Date("Y-m-d H:i:s"));
			$list[$key]->currentdate =  Date("Y-m-d H:i:s");			
		}
	}

	// Sort Data updated_at
	usort($list, function($a,$b){
		if ($a->updated_at==$b->updated_at) return 0;
 		return ($a->updated_at > $b->updated_at)?-1:1;
	});

	$json = json_decode(json_encode($list), true);
	return $json;
}

function save_content($data) {
	$file = get_file();

	file_put_contents($file,  json_encode($data));

	return get_content();
}	

function update_status($id, $status) {
	$data = get_content();

	foreach ($data as $key => $record) {
		if($record['id'] == $id) {
			$data[$key]['status'] = $status;
			$data[$key]['updated_at'] = time();
			break;
		}
	}

	return save_content(array_values($data));
}

function update_record($id, $newData) {
	$data = get_content();

	foreach ($data as $key => $record) {
		if($record['id'] == $id) {
			$data[$key] = $newData;
			break;
		} 
	}

	return save_content(array_values($data));
}

function update_date($id, $dateTime) {
	$data = get_content();

	foreach ($data as $key => $record) {
		if($record['id'] == $id) {
			$data[$key]['dateTime'] = $dateTime;
			$data[$key]['updated_at'] = time();
			break;
		} 
	}

	return save_content(array_values($data));
}

function delete_record($id) {
	$data = get_content();

	foreach ($data as $key => $record) {
		if($record['id'] == $id) {
			unset($data[$key]);
			break;
		}
	}

	return save_content(array_values($data));
}

function new_record($newData) {
	$data = get_content();

	$contactList = $newData['contactList'];
    $message = $newData['message'];

    $phoneNamePair = explode("\n", $contactList);
    $multiInsertValues = [];

    foreach($phoneNamePair as $pair) {
        $pairValues = explode(';', $pair);
        $name = trim($pairValues[0]);
        $phone = trim($pairValues[1]);

        array_push($data,[
        	"id" => md5(time().rand(2, 40000)),
        	"name" => $name,
        	"phone" => $phone,
        	"message" => $message,
        	"status" => "pending",
        	"updated_at" => time(),
        ]);
    }

	return save_content(array_values($data));
}

switch ($action) {
	case "GET":
		$data = get_content();

		echo json_encode(["status" => true, "data" => $data]);
		die();
	break;

	case "POST":
		$data = $_POST;
		unset($data['action']);
		$data['updated_at'] = time();
		$data = new_record($data);

		echo json_encode(["status" => true, "data" => $data]);
		die();
	break;

	case 'PATCH':
		$data = $_POST;
		unset($data['action']);
		$data['updated_at'] = time();
		$data = update_record($data['id'], $data);
		echo json_encode(["status" => true, "data" => $data]);
		die();
	break;

	case "DELETE":
		$data = $_POST;
		unset($data['action']);

		$data = delete_record($data['id']);

		echo json_encode(["status" => true, "data" => $data]);
	break;

	case "STATUSPATCH":
		$data = $_POST;
		unset($data['action']);
		$data = update_status($data['id'], 'contacted');
		echo json_encode(["status" => true, "data" => $data]);
	break;

	case "udateDateTime":
			$data = $_POST;
			unset($data['action']);
			$data = update_date($data['id'], $data['dateTime']);
			echo json_encode(["status" => true, "data" => $data]);
	break;
	
	default:
		echo json_encode(["status" => false]);
		die();
	break;
}

?>