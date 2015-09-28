<?php

/**
 * Mail_Job is used to schedule mass Mailings. When a mass mailing is started, a Mail_Job object should be created and stored in the Database for each and every subscriber of the Mail.
 * Then, as the mail queue is processed, the Mail_Job objects are retrieved from the Database and executed.
 */
class Mail_Job extends Resource {
    
    const QUEUED = 0;
    const DONE   = 1;
    
    /**
     * Sets the Mail Id for this Job. 
     * @param int $mailId
     * @return Mail_Job
     */
    public function setMailId($mailId) {
        return $this->writeAttributeValue('mail_id', $mailId);
    }
    
    /**
     * Returns the Mail Id for this Job. When executing the Job, a Mail object should be created with this Id,
     * then sent to the address determined by calling getEmail() and getName().
     * @return int
     */
    public function getMailId() {
        return $this->readAttributeValue('mail_id');
    }
    
    /**
     * Sets the email address of the receipent for this Job.
     * @param string $email
     * @return Mail_Job
     */
    public function setEmail($email) {
        return $this->writeAttributeValue('email', $email);
    }
    
    /**
     * Returns the email address where the Mail should be sent in this Job.
     * @return string
     */
    public function getEmail() {
        return $this->readAttributeValue('email');
    }

    /**
     * Sets the name of the person the Mail should be sent to. Use together with setEmail().
     * @param string $name
     * @return Mail_Job
     */
    public function setName($name) {
        return $this->writeAttributeValue('name', $name);
    }
    
    /**
     * Returns the name of the person this Mail should be sent to.
     * @return string
     */
    public function getName() {
        return $this->readAttributeValue('name');
    }
    
    /**
     * Sets the status of the Job - either to Mail_Job::QUEUED (needs to be done), or Mail_Job::DONE (already done).
     * @param int $status
     * @return Mail_Job
     */
    
    public function setStatus($status) {
        return $this->writeAttributeValue('status', $status);
    }
    
    /**
     * Returns the status of the Job. If Mail_Job::QUEUED is returned, the Job still needs to be processed. 
     * If Mail_Job::DONE is returned, the Job has already been processed.
     * @return int
     */
    public function getStatus() {
        return $this->readAttributeValue('status');
    }
    
    /**
     * Sets the start time of the Mail Job. This should be the exact time when the Job is created.
     * @param string    $startTime  The start time, in YYYY-MM-DD HH:MM:SS format
     * @return Mail_Job
     */
    public function setStartTimestamp($startTime) {
        return $this->writeAttributeValue('start_timestamp', $startTime);
    }
    
    /**
     * Returns the date and time when the Mail Job was created.
     * @return string
     */
    public function gegStartTimestamp() {
        return $this->readAttributeValue('start_timestamp');
    }
    
    /**
     * Sets the time when the Job was done.
     * @param string $finishTime    The finish time, in YYYY-MM-DD HH:MM:SS format
     * @return Mail_Job
     */
    public function setFinishTimestamp($finishTime) {
        return $this->writeAttributeValue('finish_timestamp', $finishTime);
    }
    
    /**
     * Returns the date and time when the Job was finished.
     * If getStatus() is not Mail_Job::DONE, the return value of this method is meaningless.
     * @return string
     */
    public function getFinishTimestamp() {
        return $this->readAttributeValue('finish_timestamp');
    }
    
    
}
