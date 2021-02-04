<?php


namespace Aankhijhyaal\LaraSparrow;


class SmsMessage {
  /**
   * @var string
   */
  private  $_recipient;

  /**
   * @var string
   */
  private  $_content;

  /**
   * @return string
   */
  public function getRecipient()
  {
    return $this->_recipient;
  }

  /**
   * @param string $recipient
   * @return $this
   */
  public function setRecipient($recipient)
  {
    $this->_recipient = $recipient;
    return $this;
  }

  /**
   * @return string
   */
  public function getContent()
  {
    return $this->_content;
  }

  /**
   * @param string $content
   * @return $this
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }
}
