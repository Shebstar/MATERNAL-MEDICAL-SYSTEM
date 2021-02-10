<?php
session_start();
include "../function.php";
include "../config_settings.php";
if (!trim($_SESSION['id']) and !isset($_SESSION['username'])) {
    header($root_system_url);
}
?>
<section class="statistic">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="au-inbox-wrap js-inbox-wrap">
                        <div class="au-message js-list-load">
                            <div class="au-message-list">
                                <div class="au-message__item unread">
                                    <div class="au-message__item-inner">
                                        <div class="au-message__item-text">
                                            <div class="avatar-wrap">
                                                <div class="avatar">
                                                    <img src="../images/avatr.png" alt="John Smith">
                                                </div>
                                            </div>
                                            <div class="text">
                                                <h5 class="name">Catherine Fungo</h5>
                                                <p>Book an appointment</p>
                                            </div>
                                        </div>
                                        <div class="au-message__item-time">
                                            <span>12 Min ago</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="au-message__item unread">
                                    <div class="au-message__item-inner">
                                        <div class="au-message__item-text">
                                            <div class="avatar-wrap online">
                                                <div class="avatar">
                                                    <img src="../images/avatr.png" alt="Nicholas Martinez">
                                                </div>
                                            </div>
                                            <div class="text">
                                                <h5 class="name">Joyce Ally</h5>
                                                <p>Poor services received</p>
                                            </div>
                                        </div>
                                        <div class="au-message__item-time">
                                            <span>11:00 PM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="au-message__item">
                                    <div class="au-message__item-inner">
                                        <div class="au-message__item-text">
                                            <div class="avatar-wrap online">
                                                <div class="avatar">
                                                    <img src="../images/doc_ava.jpg" alt="Michelle Sims">
                                                </div>
                                            </div>
                                            <div class="text">
                                                <h5 class="name">Clinical Guidelines</h5>
                                                <p>

                                                <h5>Management of inevitable abortion in Dispensary & Health Centre</h5>
                                                <ul>
                                                    <li>Apply Airway, Breathing, Circulation and Dehydration (ABCD) principles of resuscitation </li>
                                                    <li>Check Hb level. </li>
                                                    <li>Give IV Ringers Lactate (RL)/Normal Saline (NS) 2litres</li>
                                                    <li>Perform Manual Vacuum Aspiration (MVA) in health centre if gestation age is below 12 weeks </li>
                                                    <li>Augment the process by administering oxytocin 20 IU in 500mls RL/NS at 40–60 drops/minute if gestation age is above 12 weeks </li>
                                                    <li>Manage as incomplete abortion if after augmentation some products of conception remain in the uterus </li>
                                                    <li>Manage as complete abortion if all product of conception are expelled</li>
                                                </ul>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="au-message__item-time">
                                            <span>Yesterday</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="au-message__item">
                                    <div class="au-message__item-inner">
                                        <div class="au-message__item-text">
                                            <div class="avatar-wrap">
                                                <div class="avatar">
                                                    <img src="../images/avatr.png" alt="Michelle Sims">
                                                </div>
                                            </div>
                                            <div class="text">
                                                <h5 class="name">Michelle Sims</h5>
                                                <p>Purus feugiat finibus</p>
                                            </div>
                                        </div>
                                        <div class="au-message__item-time">
                                            <span>Sunday</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>