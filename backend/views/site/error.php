<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
use yii\helpers\Html;
use backend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);

$this->title = $name;
?>


<style type="text/css">
    
/* BODY */
body {

  /*transform: rotate(-5deg);*/
  background-color: #34495e;
 
  background-attachment: fixed;
  background-size: 100% 100%;
  overflow: hidden;
}

h1 {
  cursor: default;
  position: absolute;
  top: 30px;
  left: 0;
  right: 0;
  bottom: 0;
  height: 100px;
  margin: auto;
  display: block;
  
  -webkit-animation: bounce .3s ease infinite alternate;
  
  font-family: 'verdana', cursive;
  font-size: 80px;
  color: #FFF;
  text-align: center;
  line-height: 100px;
  text-shadow: 0 1px 0 #CCC,
               0 2px 0 #CCC,
               0 3px 0 #CCC,
               0 4px 0 #CCC,
               0 5px 0 #CCC,
               0 6px 0 transparent,
               0 7px 0 transparent,
               0 8px 0 transparent,
               0 9px 0 transparent,
               0 10px 10px rgba(0, 0, 0, .6);
}
/* ANIMATION */
@-webkit-keyframes bounce {
  100% {
    top: -30px;
    
    text-shadow: 0 1px 0 #CCC,
                 0 2px 0 #CCC,
                 0 3px 0 #CCC,
                 0 4px 0 #CCC,
                 0 5px 0 #CCC,
                 0 6px 0 #CCC,
                 0 7px 0 #CCC,
                 0 8px 0 #CCC,
                 0 9px 0 #CCC,
                 0 30px 30px rgba(0, 0, 0, .3);
  }
}

.talk-bubble {
    margin: 40px;
  display: inline-block;
  position: relative;
    width: 500px;
    height: auto;
    background-color: lightyellow;
}
.border{
  border: 8px solid #666;
}
.round{
  border-radius: 30px;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;

}

/* Right triangle placed top left flush. */
.tri-right.border.left-top:before {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: -40px;
    right: auto;
  top: -8px;
    bottom: auto;
    border: 32px solid;
    border-color: #666 transparent transparent transparent;
}
.tri-right.left-top:after{
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: -20px;
    right: auto;
  top: 0px;
    bottom: auto;
    border: 22px solid;
    border-color: lightyellow transparent transparent transparent;
}

/* Right triangle, left side slightly down */
.tri-right.border.left-in:before {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: -40px;
    right: auto;
  top: 30px;
    bottom: auto;
    border: 20px solid;
    border-color: #666 #666 transparent transparent;
}
.tri-right.left-in:after{
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: -20px;
    right: auto;
  top: 38px;
    bottom: auto;
    border: 12px solid;
    border-color: lightyellow lightyellow transparent transparent;
}

/*Right triangle, placed bottom left side slightly in*/
.tri-right.border.btm-left:before {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
    left: -8px;
  right: auto;
  top: auto;
    bottom: -40px;
    border: 32px solid;
    border-color: transparent transparent transparent #666;
}
.tri-right.btm-left:after{
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
    left: 0px;
  right: auto;
  top: auto;
    bottom: -20px;
    border: 22px solid;
    border-color: transparent transparent transparent lightyellow;
}

/*Right triangle, placed bottom left side slightly in*/
.tri-right.border.btm-left-in:before {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
    left: 30px;
  right: auto;
  top: auto;
    bottom: -40px;
    border: 20px solid;
    border-color: #666 transparent transparent #666;
}
.tri-right.btm-left-in:after{
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
    left: 38px;
  right: auto;
  top: auto;
    bottom: -20px;
    border: 12px solid;
    border-color: lightyellow transparent transparent lightyellow;
}

/*Right triangle, placed bottom right side slightly in*/
.tri-right.border.btm-right-in:before {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: auto;
    right: 30px;
    bottom: -40px;
    border: 20px solid;
    border-color: #666 #666 transparent transparent;
}
.tri-right.btm-right-in:after{
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: auto;
    right: 38px;
    bottom: -20px;
    border: 12px solid;
    border-color: lightyellow lightyellow transparent transparent;
}
/*
    left: -8px;
  right: auto;
  top: auto;
    bottom: -40px;
    border: 32px solid;
    border-color: transparent transparent transparent #666;
    left: 0px;
  right: auto;
  top: auto;
    bottom: -20px;
    border: 22px solid;
    border-color: transparent transparent transparent lightyellow;

/*Right triangle, placed bottom right side slightly in*/
.tri-right.border.btm-right:before {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: auto;
    right: -8px;
    bottom: -40px;
    border: 20px solid;
    border-color: #666 #666 transparent transparent;
}
.tri-right.btm-right:after{
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: auto;
    right: 0px;
    bottom: -20px;
    border: 12px solid;
    border-color: lightyellow lightyellow transparent transparent;
}

/* Right triangle, right side slightly down*/
.tri-right.border.right-in:before {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: auto;
    right: -40px;
  top: 30px;
    bottom: auto;
    border: 20px solid;
    border-color: #666 transparent transparent #666;
}
.tri-right.right-in:after{
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: auto;
    right: -20px;
  top: 38px;
    bottom: auto;
    border: 12px solid;
    border-color: lightyellow transparent transparent lightyellow;
}

/* Right triangle placed top right flush. */
.tri-right.border.right-top:before {
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: auto;
    right: -40px;
  top: -8px;
    bottom: auto;
    border: 32px solid;
    border-color: #666 transparent transparent transparent;
}
.tri-right.right-top:after{
    content: ' ';
    position: absolute;
    width: 0;
    height: 0;
  left: auto;
    right: -20px;
  top: 0px;
    bottom: auto;
    border: 20px solid;
    border-color: lightyellow transparent transparent transparent;
}

/* talk bubble contents */
.talktext{
  padding: 1em;
    text-align: left;
  line-height: 1.5em;
}
.talktext p{
  /* remove webkit p margins */
  -webkit-margin-before: 0em;
  -webkit-margin-after: 0em;
}

</style>

<div class="row">
    <div class="col-sm-6">
        <div class="talk-bubble tri-right round btm-left" style>
              <div class="talktext">
                <p>
                    The above error occurred while the Web server was processing your request.
                </p>
                <p>
                    Please contact us if you think this is a server error. Thank you.
                </p>
            </div>
        </div>
    </div>
<!--     <div class="col-sm-2">
    <div class="talk-bubble tri-right round btm-left " style="width: 200px !important;">
      <div class="talktext">
        <p><?=  nl2br(Html::encode($message)) ?></p>
      </div>
    </div>
    </div> -->
</div>
<h1><?= $this->title ?></h1>
