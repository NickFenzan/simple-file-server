<?php
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

$app->match('/', function(Request $request) use ($app){
  $form = $app['form.factory']
        ->createBuilder(FormType::class)
        ->add('Appointments', FileType::class)
        ->add('Patients', FileType::class)
        ->add('Transactions', FileType::class)
        ->getForm();

  if ($request->isMethod('POST')) {
    $form->handleRequest($request);
    if ($form->isValid()) {
      $files = ($request->files->get($form->getName()));
      $path = $app['upload_path'];
      $files['Appointments']->move($path,'appointments.csv');
      $files['Patients']->move($path,'patients.csv');
      $files['Transactions']->move($path,'transactions.csv');
      $message = 'File was successfully uploaded!';
    }
  }

  return $app['twig']->render('patients-upload.html', array(
    'form' => $form->createView(),
    'message' => $message
  ));
}, 'GET|POST');

$app->get('/appointments', function() use ($app) {
  $path = $app['upload_path'];
  $filename = 'appointments.csv';
  if (!file_exists($path . $filename)) {
    $app->abort(404);
  }

  return $app->sendFile($path . $filename)
  ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
});

$app->get('/patients', function() use ($app) {
  $path = $app['upload_path'];
  $filename = 'patients.csv';
  if (!file_exists($path . $filename)) {
    $app->abort(404);
  }

  return $app->sendFile($path . $filename)
  ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
});

$app->get('/transactions', function() use ($app) {
  $path = $app['upload_path'];
  $filename = 'transactions.csv';
  if (!file_exists($path . $filename)) {
    $app->abort(404);
  }

  return $app->sendFile($path . $filename)
  ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
});
