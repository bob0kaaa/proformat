<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('Proformat@tu-ugmk.com', 'Заявка на участие в "ProFormat"');
	//Кому отправить
	$mail->addAddress('proformat.tu-ugmk@yandex.ru');
	//Тема письма
	$mail->Subject = 'Заявка на участие в "ProFormat"';


	//Рука
	
	if($_POST['hand'] == "Спонсор"){
		$hand = "Спонсор";
		$age = $_POST['age'];
	}
	
	if($_POST['hand'] == "Участник"){
		$hand = "Участник";
		$age = " ";
	}

	//Тело письма
	$body = '<h1>Заявка на участие в "ProFormat"</h1>';
	
	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
	}
	if(trim(!empty($_POST['company']))){
		$body.='<p><strong>Компания:</strong> '.$_POST['company'].'</p>';
	}
	if(trim(!empty($_POST['email']))){
		$body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
	}
	if(trim(!empty($_POST['tel']))){
		$body.='<p><strong>Телефон:</strong> '.$_POST['tel'].'</p>';
	}
	if(trim(!empty($_POST['hand']))){
		$body.='<p><strong>Форма заявки:</strong> '.$hand.'</p>';
	}
	if(trim(!empty($_POST['age']))){
		$body.='<p><strong>Категория пакета:</strong> '.$age.'</p>';
	}
	if(trim(!empty($_POST['message']))){
		$body.='<p><strong>Комментарий:</strong> '.$_POST['message'].'</p>';
	}
	
	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/" . $_FILES['image']['name']; 
		//грузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Фото в приложении</strong>';
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$message = 'Данные отправлены!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>