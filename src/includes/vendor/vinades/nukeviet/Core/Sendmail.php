<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

namespace NukeViet\Core;

use NukeViet\Site;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * NukeViet\Core\Sendmail
 *
 * @package NukeViet\Core
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @version 5.x
 * @access public
 */
class Sendmail extends PHPMailer
{
    private $configs = [];

    private $sender_name = '';

    private $sender_address = '';

    private $myFrom = [];

    private $myReply = [];

    private $logo = false;

    private $mailhtml = true;

    private $maillang = 'en';

    /**
     * __construct()
     *
     * @param array  $config
     * @param string $mail_lang
     * @throws Exception
     */
    public function __construct($config, $mail_lang)
    {
        parent::__construct();
        $this->maillang = $mail_lang;
        $this->SetLanguage($mail_lang);
        $this->CharSet = $config['site_charset'];
        $this->configs = $config;

        $mailer_mode = strtolower($this->configs['mailer_mode']);

        if ($mailer_mode == 'smtp') {
            $this->isSMTP();
            $this->SMTPAuth = true;
            $this->Port = $this->configs['smtp_port'];
            $this->Host = $this->configs['smtp_host'];
            $this->Username = $this->configs['smtp_username'];
            $this->Password = $this->configs['smtp_password'];

            $SMTPSecure = (int) ($this->configs['smtp_ssl']);
            switch ($SMTPSecure) {
                case 1:
                    $this->SMTPSecure = 'ssl';
                    break;
                case 2:
                    $this->SMTPSecure = 'tls';
                    break;
                default:
                    $this->SMTPSecure = '';
            }
            $this->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => ($this->configs['verify_peer_ssl'] == 1) ? true : false,
                    'verify_peer_name' => ($this->configs['verify_peer_name_ssl'] == 1) ? true : false,
                    'allow_self_signed' => true
                ]
            ];
        } elseif ($mailer_mode == 'sendmail') {
            $this->IsSendmail();
        } elseif ($mailer_mode == 'mail') {
            if (Site::function_exists('mail')) {
                $this->IsMail();
            } else {
                $this->Mailer = 'no';
            }
        } else {
            $this->Mailer = 'no';
        }
    }

    /**
     * addFile()
     *
     * @param string $file
     * @return true
     * @throws Exception
     */
    public function addFile($file)
    {
        $this->addAttachment($file);

        return true;
    }

    /**
     * addLogo()
     *
     * @return true
     */
    public function addLogo()
    {
        $this->logo = true;

        return true;
    }

    /**
     * setMailHtml()
     *
     * @param bool $mailhtml
     */
    public function setMailHtml($mailhtml = true)
    {
        $this->mailhtml = (float) $mailhtml;
    }

    /**
     * setSender()
     *
     * @param string $address
     * @param string $name
     */
    public function setSender($address, $name = '')
    {
        $this->sender_address = $address;
        $this->sender_name = $name;
    }

    /**
     * addFrom()
     *
     * @param string $address
     * @param string $name
     * @return true
     */
    public function addFrom($address, $name = '')
    {
        $this->myFrom[$address] = $name;

        return true;
    }

    /**
     * addReply()
     *
     * @param string $address
     * @param string $name
     */
    public function addReply($address, $name = '')
    {
        $this->myReply[$address] = $name;
    }

    /**
     * addTo()
     *
     * @param string $address
     * @param string $name
     * @return bool
     * @throws Exception
     */
    public function addTo($address, $name = '')
    {
        return $this->addAddress($address, nv_unhtmlspecialchars($name));
    }

    /**
     * addCC()
     *
     * @param string $address
     * @param string $name
     * @return bool
     * @throws Exception
     */
    public function addCC($address, $name = '')
    {
        return $this->addOrEnqueueAnAddress('cc', $address, nv_unhtmlspecialchars($name));
    }

    /**
     * addBCC()
     *
     * @param string $address
     * @param string $name
     * @return bool
     * @throws Exception
     */
    public function addBCC($address, $name = '')
    {
        return $this->addOrEnqueueAnAddress('bcc', $address, nv_unhtmlspecialchars($name));
    }

    /**
     * setSubject()
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->Subject = $subject;
    }

    /**
     * setContent()
     *
     * @param string $message
     */
    public function setContent($message)
    {
        $this->Body = $message;
    }

    /**
     * _formatBody()
     *
     * @param mixed $Body
     * @return string
     */
    private static function _formatBody($Body)
    {
        $Body = nv_url_rewrite($Body);
        $optimizer = new Optimizer($Body, NV_BASE_SITEURL);
        $Body = $optimizer->process(false);

        return nv_unhtmlspecialchars($Body);
    }

    /**
     * _setFrom()
     *
     * @throws Exception
     */
    private function _setFrom()
    {
        $force_sender = !empty($this->configs['force_sender']) && !empty($this->configs['sender_email']);
        if ($force_sender) {
            $sender_name = !empty($this->configs['sender_name']) ? $this->configs['sender_name'] : $this->configs['site_name'];
            $this->setFrom($this->configs['sender_email'], nv_unhtmlspecialchars($sender_name));
        } else {
            $sender_email = !empty($this->sender_address) ? $this->sender_address : (!empty($this->configs['sender_email']) ? $this->configs['sender_email'] : '');
            $sender_name = !empty($this->sender_name) ? $this->sender_name : (!empty($this->configs['sender_name']) ? $this->configs['sender_name'] : $this->configs['site_name']);

            if (empty($sender_email)) {
                if ($this->Mailer == 'smtp') {
                    if (filter_var($this->configs['smtp_username'], FILTER_VALIDATE_EMAIL)) {
                        $sender_email = $this->configs['smtp_username'];
                    }
                } elseif ($this->Mailer == 'sendmail') {
                    if (isset($_SERVER['SERVER_ADMIN']) and !empty($_SERVER['SERVER_ADMIN']) and filter_var($_SERVER['SERVER_ADMIN'], FILTER_VALIDATE_EMAIL)) {
                        $sender_email = $_SERVER['SERVER_ADMIN'];
                    } elseif (checkdnsrr($_SERVER['SERVER_NAME'], 'MX') || checkdnsrr($_SERVER['SERVER_NAME'], 'A')) {
                        $sender_email = 'webmaster@' . $_SERVER['SERVER_NAME'];
                    }
                } elseif ($this->Mailer == 'mail') {
                    if (($php_email = @ini_get('sendmail_from')) != '' and filter_var($php_email, FILTER_VALIDATE_EMAIL)) {
                        $sender_email = $php_email;
                    } elseif (preg_match("/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+/", ini_get('sendmail_path'), $matches) and filter_var($matches[0], FILTER_VALIDATE_EMAIL)) {
                        $sender_email = $matches[0];
                    } elseif (checkdnsrr($_SERVER['SERVER_NAME'], 'MX') || checkdnsrr($_SERVER['SERVER_NAME'], 'A')) {
                        $sender_email = 'webmaster@' . $_SERVER['SERVER_NAME'];
                    }
                }
            }
            empty($sender_email) && $sender_email = $this->configs['site_email'];
            $this->setFrom($sender_email, nv_unhtmlspecialchars($sender_name));
        }
    }

    /**
     * _setReply()
     *
     * @throws Exception
     */
    private function _setReply()
    {
        $force_reply = !empty($this->configs['force_reply']) and !empty($this->configs['reply_email']);
        if ($force_reply) {
            $this->addReplyTo($this->configs['reply_email'], nv_unhtmlspecialchars($this->configs['reply_name']));
        } else {
            $reply = $this->myFrom + $this->myReply;
            if (empty($reply) and !empty($this->configs['reply_email'])) {
                $reply[$this->configs['reply_email']] = $this->configs['reply_name'];
            }
            if (!empty($reply)) {
                foreach ($reply as $reply_email => $reply_name) {
                    empty($reply_name) && $reply_name = $this->configs['site_name'];
                    $this->addReplyTo($reply_email, nv_unhtmlspecialchars($reply_name));
                }
            }
        }
    }

    /**
     * _addDKIM()
     */
    private function _addDKIM()
    {
        $dkim_included = !empty($this->configs['dkim_included']) ? array_map('trim', explode(',', $this->configs['dkim_included'])) : [];
        if (!empty($dkim_included) and in_array($this->Mailer, $dkim_included, true)) {
            // https://github.com/PHPMailer/PHPMailer/blob/master/examples/DKIM_sign.phps
            $domain = substr(strstr($this->From, '@'), 1);
            $privatekeyfile = NV_ROOTDIR . '/' . NV_CERTS_DIR . '/nv_dkim.' . $domain . '.private.pem';
            $verifiedkey = NV_ROOTDIR . '/' . NV_CERTS_DIR . '/nv_dkim.' . $domain . '.verified';
            if (file_exists($verifiedkey)) {
                $verifiedTime = file_get_contents($verifiedkey);
                $verifiedTime = (int) $verifiedTime + 604800;
                if (NV_CURRENTTIME > $verifiedTime) {
                    $verified = DKIM_verify($domain, 'nv');
                    if (!$verified) {
                        @unlink($verifiedkey);
                    } else {
                        $verifiedTime = NV_CURRENTTIME;
                        file_put_contents($verifiedkey, $verifiedTime, LOCK_EX);
                    }
                }
                if (NV_CURRENTTIME <= $verifiedTime and file_exists($privatekeyfile)) {
                    $this->DKIM_domain = $domain;
                    $this->DKIM_private = $privatekeyfile;
                    $this->DKIM_selector = 'nv';
                    $this->DKIM_passphrase = '';
                    $this->DKIM_identity = $this->From;
                    $this->DKIM_copyHeaderFields = false;
                    $this->DKIM_extraHeaders = ['List-Unsubscribe', 'List-Help'];
                }
            }
        }
    }

    /**
     * _addSMIME()
     */
    private function _addSMIME()
    {
        $smime_included = !empty($this->configs['smime_included']) ? array_map('trim', explode(',', $this->configs['smime_included'])) : [];
        if (!empty($smime_included) and in_array($this->Mailer, $smime_included, true)) {
            // This PHPMailer example shows S/MIME signing a message and then sending.
            // https://github.com/PHPMailer/PHPMailer/blob/master/examples/smime_signed_mail.phps
            $email_name = str_replace('@', '__', $this->From);
            $cert_key = NV_ROOTDIR . '/' . NV_CERTS_DIR . '/' . $email_name . '.key';
            $cert_crt = NV_ROOTDIR . '/' . NV_CERTS_DIR . '/' . $email_name . '.crt';
            $certchain_pem = file_exists(NV_ROOTDIR . '/' . NV_CERTS_DIR . '/' . $email_name . '.pem') ? NV_ROOTDIR . '/' . NV_CERTS_DIR . '/' . $email_name . '.pem' : '';
            if (file_exists($cert_key) and file_exists($cert_crt)) {
                $this->sign(
                    $cert_crt, // The location of your certificate file
                    $cert_key, // The location of your private key file
                    // The password you protected your private key with (not the Import Password!
                    // May be empty but the parameter must not be omitted!
                    '',
                    $certchain_pem // The location of your chain file
                );
            }
        }
    }

    /**
     * send()
     *
     * @return bool
     * @throws Exception
     */
    public function send()
    {
        if ($this->Mailer == 'no') {
            return false;
        }
        $this->_setFrom();
        $this->_setReply();

        // https://www.php.net/manual/en/function.mail.php
        // Lines should not be larger than 70 characters.
        $this->WordWrap = 70;
        $this->IsHTML(true);
        $this->XMailer = 'NukeViet CMS with PHPMailer';

        $this->AltBody = strip_tags($this->Body);

        if ($this->mailhtml) {
            $this->Body = mailAddHtml($this->Subject, $this->Body, $this->configs, $this->maillang);
            $this->logo = true;
        }

        $this->Subject = nv_unhtmlspecialchars($this->Subject);
        $this->Body = self::_formatBody($this->Body);

        if ($this->logo) {
            $this->AddEmbeddedImage(NV_ROOTDIR . '/' . $this->configs['site_logo'], 'sitelogo', basename(NV_ROOTDIR . '/' . $this->configs['site_logo']));
        }

        $this->_addSMIME();
        $this->_addDKIM();

        try {
            if (!$this->preSend()) {
                return false;
            }

            return $this->postSend();
        } catch (Exception $exc) {
            $this->mailHeader = '';
            $this->setError($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }

            return false;
        }
    }
}
