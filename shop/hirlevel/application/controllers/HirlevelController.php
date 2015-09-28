<?php

class HirlevelController extends AbstractController {
    
    public function isAuthorized($action) {
        switch ($action) {
            case 'error' :
            case 'leiratkozas' :
            case 'teszt' :
                $authorized = true;
                break;
            default :
                $authorized = ((null != $this->identity) && (3 <= $this->identity['level']));
                break;
        }
        return $authorized;
    }
    
    public function indexAction() {
        $this->redirect('hirlevel', 'piszkozat');
    }

    public function tesztAction() {
        /*$model = new Mail();
        $model->setId(12);
        $model->read();
        $model->setStatus(Mail::SENT);
        $model->save();*/

        //$u = new CbaUnsubscriberModel();
        //$u->read();
        //$value = '';
        //while ($u) {
            /*$model = new CbaRemoteIdentityModel();
            //$model->setEmail('robertbanki@gmail.com  ');
            $model->read();
            if (!$model->isEmptyCollection()) {
                while ($model) {
                    $value .= $model->getId() . ', ' . $model->getFullName() . ', ' . $model->getEmail() . "\n";
                    $model = $model->next();
                }
            }*/
            //$u = $u->next();
        //}
        
        $model = new Mail_Job();
        $model->setStatus(Mail_Job::QUEUED);
        $value = $model->count();

        //$value = 'X';


        
        echo '<html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Teszt</title></head><body><pre>“Amíg léteznek alsóbb néprétegek, én közéjük tartozom. Amíg léteznek bűnöző elemek, magam is az vagyok. Amíg egyetlen lélek is börtönben sínylődik, én sem vagyok szabad.” ' . "\n\n" . 'A kérédésére a válasz pedig: ' . "\n" . $value . '</pre></body></html>';
        die();
        
        //$model = new Mail();
        //echo "<pre>" . $model->setStatus(Mail::TRASH)->setCreationTimestamp(new DbExpression_GreaterThan('2010-12-13 02:00:00'))->count() . " db </pre>";
        
        /*
        $model = new CbaRemoteIdentityModel();
        $model->setId(1)->read();
        $resource = mssql_query('SELECT * FROM dbo.UGYFELEK WHERE ID_CEG <> NULL');
        if ($resource) {
            while ($record = mssql_fetch_assoc($resource)) {
                echo "<pre>";
                var_dump($record);
                echo "\n\n--------------------------------------------------------------------------------------\n</pre>\n";
            }
        }
        */
        
    }
    
    public function xsendAction() {
        die('You no take candle!');
        //$mailId = 18;
        
        $model = new Mail();
        $model->setId($mailId)->read();
        if (!$model->isEmptyCollection()) {
            $theme = new Mail_Theme();
            $theme->setThemePath('themes/mail/')
                    ->setThemeName('cba-fitness')
                    ->setAssetPath('http://www.cbafitness.hu/themes/mail/cba-fitness/assets')
                    ->setTitle($model->getSubject())
                    ->setContent(stripslashes($model->getBody()))
                    ->setLegal('<p>Ön kifejezett hozzájárulását adta ahhoz, hogy adatait a CBA Fitness and Welness Line (1103 Budapest, Gyömrői út 99. Telefon: 1/431-01-32 | Fax: 1/431-01-33) saját marketingtevékenysége céljából, illetve a kutatás és közvetlen üzletszerzés célját szolgáló név és lakcímadatok kezeléséről szóló 1995. évi CXIX. törvényben meghatározott piackutatás és közvetlen üzletszerzés céljára felhasználja, a fenti célok megvalósítása érdekében elektronikus levelezés vagy azzal egyenértékű egyéni kommunikációs eszköz, sms útján, illetve postai úton Önt megkeresse.</p><p>Adatai gépi úton kerülnek feldolgozásra.Tájékoztatjuk, hogy adatai harmadik felek részére kizárólag az adatvédelmi szabályzatban részletezettek szerint kerülnek továbbításra. Adatai kezeléséhez adott hozzájárulását bármikor, korlátozás és indokolás nélkül, ingyenesen jogosult visszavonni továbbá jogában áll adatainak a megjelölt célra vagy annak egy részére történő kezelésének megszüntetését kérni. Az Adatkezelő az Ön adatait kizárólag tiltási nyilatkozatának kézhezvételéig kezeli. <a href="http://www.cbafitness.hu/hirlevel/hirlevel.php?id=leiratkozas">Leiratkozás</a></p>');

            require_once 'lib/phpmailer/class.phpmailer.php';
            
            $mailer = new PHPMailer();
            $mailer->CharSet = 'utf-8';
            $mailer->IsHTML();
            $mailer->IsSMTP();
            $mailer->Host = 'smtp.anaiz.hu';
            $mailer->Subject = $model->getSubject();
            $mailer->Body = $theme->render();
            $mailer->SetFrom('noreply@cbafitness.hu', 'CBA Fitness');
            

            echo '<html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"><title>Teszt</title></head><body>';
            
            $job = new Mail_Job();
            $job->setMailId($mailId)->setStatus(Mail_Job::QUEUED)->read();
            if (!$job->isEmptyCollection()) {
                /*$mailer->AddAddress('tiga80@gmail.com', 'Tigaaa');
                if ($mailer->Send()) {
                        $jobDone = new Mail_Job();
                        $jobDone->setId(1)->setStatus(Mail_Job::DONE)->setFinishTimestamp(date('Y-m-d H:i:s'))->save();
                    
                }*/
                while ($job) {
                    $mailer->ClearAddresses();
                    $mailer->AddAddress($job->getEmail(), $job->getName());
                    if ($mailer->Send()) {
                        echo "<pre>Teszt levél kiküldve: " . $job->getEmail() . " [" . $job->getName() . "]</pre>\n";
                        
                        $jobDone = new Mail_Job();
                        $jobDone->setId($job->getId())->setStatus(Mail_Job::DONE)->setFinishTimestamp(date('Y-m-d H:i:s'))->save();
                        
                    } else {
                        echo "<pre style=\"color: #f00;\">FAILED: " . $job->getEmail() . " [" . $job->getName() . "]</pre>\n";
                    }
                    //echo "<pre>" . $job->getEmail() . " [" . $job->getName() . "]</pre>\n";
                    $job = $job->next();
                }
            }
            
            
            
        }
        
        echo '</body></html>';

        die();
    }
    
    public function kimenoAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        $view->navigationId = 'kimeno';
        $view->itemCounts = $this->countItems();
        
        $this->readItems(Mail::OUTBOX);
        
        $view->render('hirlevel/lista');
        
    }

    public function elkuldottAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        $view->navigationId = 'elkuldott';
        $view->itemCounts = $this->countItems();
        
        $this->readItems(Mail::SENT);

        $view->render('hirlevel/lista');
        
    }

    public function piszkozatAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        $view->navigationId = 'piszkozat';
        $view->itemCounts = $this->countItems();
        
        $this->readItems(Mail::DRAFT);
        
        $view->render('hirlevel/lista');
        
    }
    
    public function kukaAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        $view->navigationId = 'kuka';
        $view->itemCounts = $this->countItems();
        
        $this->readItems(Mail::TRASH);
        
        $view->render('hirlevel/lista');
        
    }
    
    public function cimtarAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        $view->navigationId = 'cimtar';
        
        $model = new CbaSubscriberModel();
        $model->read();
        
        if (!$model->isEmptyCollection()) {
            while ($model) {
                $tags = array();
                if ($model->getRemoteStatus()) $tags[] = 'Fitness';
                if ($model->getLocalStatus()) $tags[] = 'Web';
                $items[] = array(
                    //'id'        => $model->getId(),
                    'label'     => $model->getEmail(),
                    'link'      => null,
                    extras      => array(
                        'name'      => $model->getFullName(),
                        'tags'      => implode(', ', $tags),
                    ),
                );
                $model = $model->next();
            }
        }
        $view->items = $items;
        $view->labels = array(
            'label'     => 'Email-cím',
            'name'      => 'Név',
            'tags'      => 'Adatbázis',
        );
        
        $view->itemCounts = $this->countItems();
        $view->render('hirlevel/lista');
    }
    
    protected function readItems($status) {
        $view = $this->getView();
        
        $model = new Mail();
        $model->setStatus($status)->setQueryOptions(array('order_by' => 'creation_timestamp DESC'))->read();
        $items = array();
        if (!$model->isEmptyCollection()) {
            while ($model) {
                $items[] = array(
                    'id'        => $model->getId(),
                    'label'     => ('' != $model->getSubject()) ? $model->getSubject() : '[Tárgy nélkül]',
                    'link'      => Request::link('hirlevel', 'uzenet', array('uzenet' => $model->getId())),
                    extras      => array(
                        'date'      => $model->getCreationTimestamp(),
                    ),
                );
                $model = $model->next();
            }
        }
        $view->items = $items;
        $view->labels = array(
            'label' => 'Tárgy',
            'date'  => 'Dátum',
        );
    }
    
    protected function countItems() {
        $counts = array();
        
        $model = new Mail();
        $counts['kimeno'] = $model->setStatus(Mail::OUTBOX)->count();
        
        $model = new Mail();
        $counts['elkuldott'] = $model->setStatus(Mail::SENT)->count();
        
        $model = new Mail();
        $counts['piszkozat'] = $model->setStatus(Mail::DRAFT)->count();
        
        $model = new Mail();
        $counts['kuka'] = $model->setStatus(Mail::TRASH)->count();
        
        $model = new Mail_Job();
        $counts['kuldes'] = $model->setStatus(Mail_Job::QUEUED)->count();
        
        return $counts;
        
}

    public function uzenetAction() {
        $view = $this->getView();
        $view->setLayout('admin');
        $view->showNavigation = true;
        
        $view->data = array(
            'id'        => 0,
            'subject'   => '',
            'body'      => '',
            'status'    => Mail::DRAFT,
        );
        
        $id = (isset($_GET['uzenet']) && (intval($_GET['uzenet']) > 0)) ? intval($_GET['uzenet']) : null ;
        
        if (Request::hasPost('mail-save')) {
            $model = new Mail();
            $model->setId($id)
                    ->setBody(trim($_POST['body']))
                    ->setSubject(trim(htmlspecialchars($_POST['subject'])));
            switch ($_POST['submit-type']) {
                case 'trash':
                    $model->setStatus(Mail::TRASH);
                    $successMessage = 'Levél kidobva a kukába.';
                    break;
                case 'live-send':
                    $model->setStatus(Mail::DRAFT);
                    // we set the status to DRAFT initially; will set it to OUTBOX when the Jobs are all set up.
                    $successMessage = 'Levél elmentve a kimenő levelek közé.';
                    break;
                case 'test-send' :
                    $model->setStatus(Mail::DRAFT);
                    $successMessage = 'Teszt levél kiküldve.';
                    break;
                case 'save' :
                default:
                    $model->setStatus(Mail::DRAFT);
                    $successMessage = 'Levél elmentve a piszkozatok közé.';
                    break;
            }
            if ($model->save()) {
                if (null === $id) {
                    $id = Registry::get('db')->getLastInsertId();
                    $model->setId($id);
                }
                if ('test-send' == $_POST['submit-type']) {
                    
                    if ('' == $model->getSubject()) {
                        $view->warning = 'Tesztküldés sikertelen. Adja meg a hírlevél tárgyát a fenti mezőben!';
                    } else {
                        // TODO This needs to be handled by a Model!
                        
                        $theme = new Mail_Theme();
                        $theme->setThemePath('themes/mail/')
                                ->setThemeName('cba-fitness')
                                ->setAssetPath('http://www.cbafitness.hu/themes/mail/cba-fitness/assets')
                                ->setTitle($model->getSubject())
                                ->setContent(stripslashes($model->getBody()))
                                ->setLegal('<p>Ön kifejezett hozzájárulását adta ahhoz, hogy adatait a CBA Fitness and Welness Line (1103 Budapest, Gyömrői út 99. Telefon: 1/431-01-32 | Fax: 1/431-01-33) saját marketingtevékenysége céljából, illetve a kutatás és közvetlen üzletszerzés célját szolgáló név és lakcímadatok kezeléséről szóló 1995. évi CXIX. törvényben meghatározott piackutatás és közvetlen üzletszerzés céljára felhasználja, a fenti célok megvalósítása érdekében elektronikus levelezés vagy azzal egyenértékű egyéni kommunikációs eszköz, sms útján, illetve postai úton Önt megkeresse.</p><p>Adatai gépi úton kerülnek feldolgozásra.Tájékoztatjuk, hogy adatai harmadik felek részére kizárólag az adatvédelmi szabályzatban részletezettek szerint kerülnek továbbításra. Adatai kezeléséhez adott hozzájárulását bármikor, korlátozás és indokolás nélkül, ingyenesen jogosult visszavonni továbbá jogában áll adatainak a megjelölt célra vagy annak egy részére történő kezelésének megszüntetését kérni. Az Adatkezelő az Ön adatait kizárólag tiltási nyilatkozatának kézhezvételéig kezeli. <a href="http://www.cbafitness.hu/hirlevel/hirlevel.php?id=leiratkozas">Leiratkozás</a></p>');
                        
                        require_once 'lib/phpmailer/class.phpmailer.php';
                        $mailer = new PHPMailer();
                        $mailer->CharSet = 'utf-8';
                        $mailer->IsHTML();
                        $mailer->IsSMTP();
                        $mailer->Host = 'localhost';
                        $mailer->Subject = '[teszt] ' . $model->getSubject();
                        $mailer->Body = $theme->render();
                        $mailer->SetFrom('noreply@cbafitness.hu', 'CBA Fitness');
                        $mailer->AddAddress($this->identity['email'], $this->identity['name']);
                        if ($mailer->Send()) {
                            $view->message = 'Teszt levél kiküldve <em>' . $this->identity['email'] . '</em> címre.';
                        } else {
                            $view->warning = $mailer->ErrorInfo;
                        }
                        
                    }
                } elseif ('live-send' == $_POST['submit-type']) {

                    // Delete previously queued jobs, if any
                    
                    //$jobModel = new Mail_Job();
                    //$jobModel->setMailId($id)->setStatus(Mail_Job::QUEUED)->delete();
                    mysql_query('DELETE FROM mail_job WHERE status = \'' . Mail_Job::QUEUED . '\' AND mail_id = \'' . $id . '\' ');  // TODO ---- QUICK & DIRTY FIX ---- WRITE THIS PROPERLY
                    
                    // Create new jobs
                    $subsciberModel = new CbaSubscriberModel();
                    $subsciberModel->read();
                    if (!$subsciberModel->isEmptyCollection()) {
                        
                        $timestamp = date('Y-m-d H:i:s');
                        
                        while ($subsciberModel) {
                            $jobModel = new Mail_Job();
                            $jobModel->setMailId($id)
                                    ->setEmail($subsciberModel->getEmail())
                                    ->setName($subsciberModel->getFullName())
                                    ->setStartTimestamp($timestamp)
                                    ->setStatus(Mail_Job::QUEUED);
                            $jobModel->save();
                            $subsciberModel = $subsciberModel->next();
                        }
                        
                    }
                        require_once 'lib/phpmailer/class.phpmailer.php';
                        $mailer = new PHPMailer();
                        $mailer->CharSet = 'utf-8';
                        $mailer->IsHTML();
                        $mailer->IsSMTP();
                        $mailer->Host = 'localhost';
                        $mailer->Subject = '[kimenő email] ' . $model->getSubject();
                        $mailer->Body = '<p>Figyelem! A CBA Fitness hírlevélküldőben kimenő email van!</p>';
                        $mailer->SetFrom('noreply@cbafitness.hu', 'CBA Fitness');
                        $mailer->AddAddress('naraan@anaiz.hu', 'Nara András');
                        $mailer->AddAddress('borsi@anaiz.hu', 'Borsi Pálma');
                        $mailer->AddAddress('geresdi@anaiz.hu', 'Geresdi Zsolt');
                        $mailer->Send();
                        
                   // Save model to OUTBOX
                    $model->setPublicationTimestamp($timestamp)->setStatus(Mail::OUTBOX);
                    $model->save();
                    
                    $view->message = $successMessage;
                } else {
                    $view->message = $successMessage;
                }
                
            } else {
                $view->warning = 'Mentés sikertelen. Nem várt hiba lépett fel.';
            }
            $view->data = array(
                'id'        => $model->getId(),
                'subject'   => $model->getSubject(),
                'body'      => $model->getBody(),
                'status'    => $model->getStatus(),
            );
        } elseif (Request::hasPost('mail-delete')) {
            $model = new Mail();
            $id = intval($_GET['uzenet']);
            $model->setId($id)->delete();
            $this->redirect('hirlevel', 'kuka');
            return false;
        } elseif ($id) {
            $model = new Mail();
            $model->setId($id);
            if ($model->read()) {
                $view->data = array(
                    'id'        => $model->getId(),
                    'subject'   => $model->getSubject(),
                    'body'      => $model->getBody(),
                    'status'    => $model->getStatus(),
                );
            }
        }
        
        switch ($view->data['status']) {
            case Mail::OUTBOX:
                $view->navigationId = 'kimeno';
                $view->enableEditing = false;
                $view->backButton = array('label' => 'kimenő', 'link' => Request::link('hirlevel', 'kimeno'));
                break;
            case Mail::SENT:
                $view->navigationId = 'elkuldott';
                $view->enableEditing = false;
                $view->backButton = array('label' => 'elküldött', 'link' => Request::link('hirlevel', 'elkuldott'));
                break;
            case Mail::TRASH:
                $view->navigationId = 'kuka';
                $view->enableEditing = false;
                $view->backButton = array('label' => 'kuka', 'link' => Request::link('hirlevel', 'kuka'));
                break;
            case Mail::DRAFT:
            default: 
                $view->navigationId = 'piszkozat';
                $view->enableEditing = true;
                $view->backButton = array('label' => 'piszkozat', 'link' => Request::link('hirlevel', 'piszkozat'));
                break;
        }
        
        $view->itemCounts = $this->countItems();
        $view->render('hirlevel/uzenet');
    }
    
    public function kuldesAction() {
        $limitPeriodStartTime = time() - 24 * 60 * 60; // we set a daily limit
        $limitPeriodStart = date('Y-m-d H:i:s', $limitPeriodStartTime);
        $limit = 15000;
        
        $model = new Mail_Job();
        $count = $model->setStatus(Mail_Job::DONE)->setFinishTimestamp(new DbExpression_GreaterOrEqualTo($limitPeriodStart))->count();
        if ($count < $limit) {
            $allowed = $limit - $count;
        } else {
            $allowed = 0;
        }
    }
    
    public function leiratkozasAction() {
        $view = $this->getView();
        $view->setLayout('denied');
        $view->showNavigation = false;
        
        if (Request::hasPost('unsubscribe')) {
            $email = trim($_POST['email']);
            if ('' != $email) {
                $model = new CbaSubscriberModel();
                $model->unsubscribe($email);
                $view->render('hirlevel/leiratkozott');
            } else {
                $view->render('hirlevel/leiratkozas');
            }
        } else {
            $view->render('hirlevel/leiratkozas');
        }
        
    }
    
}