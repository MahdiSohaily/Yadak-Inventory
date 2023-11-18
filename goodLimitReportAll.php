<?php
require_once("./views/Layout/header.php");
require_once './php/all-limit-report-getter.php';
?>
<style>
    .wrapper {
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 15px;
        margin-inline: auto;
    }

    /* tabs-section */
    .tabs {
        /* width: 100%; */
        height: 54px;
        border-radius: 8px;
        background-color: #fff;
        /* padding: 0 33px; */
        display: flex;
        align-items: center;
        overflow: hidden;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    }

    ul.tabs li {
        list-style: none;
        height: 100%;
    }

    ul.tabs li a {
        text-decoration: none;
        color: #000;
        font-weight: 500;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        padding: 0 18px;
    }

    ul.tabs a::after {
        content: "";
        width: 100%;
        position: absolute;
        top: 0;
        right: 0;
        display: none;
        border-top: 3px solid;
    }

    ul.tabs li a:hover::after,
    ul.tabs li a.active::after {
        display: block;
        border-color: #fea901;
        background-color: #fea901 !important;
    }

    /* content */
    #content {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        min-height: 130px;
    }

    #content p {
        color: gray;
        font-weight: 400;
        line-height: 2.15;
    }

    #two,
    #three,
    #four,
    #five {
        display: none;
    }

    /* media-query */
    @media only screen and (max-width: 600px) {
        .wrapper {
            width: 350px;
        }

        .tabs {
            width: 100%;
            overflow-x: auto;
        }

        ul.tabs li a {
            white-space: nowrap;
        }

        #content {
            min-height: 174px;
        }
    }

    .badge {
        width: 15px;
        height: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        background-color: red;
        padding: 5px;
        border-radius: 50%;
        margin-right: 10px;
    }
</style>

<div>
    <div>
        <div class="wrapper">
            <ul class="tabs group">
                <li>
                    <a class="orange-border active" href="#/one">
                        لیست کسرات کلی اجناس
                        <span class="badge"><?= count($needToMove) ?></span>
                    </a>
                </li>
                <!-- <li>
                    <a class="green-border" href="#/two">
                        تک آیتم ها
                        <span class="badge">10</span>
                    </a>
                </li> -->
            </ul>
            <div id="content">
                <div id="one">
                    <?php
                    foreach ($needToMove as $index => $row) :
                        $counter = 1;
                        $original = $row['original'];
                        $sumOriginal = $row['sumOriginal'];
                        $fakeNeed = $row['fake'];
                        $sumFake = $row['sumFake'];
                        $isSingle = $row['IsSingle'];
                    ?>
                        <table class="report-table" style="margin-bottom: 30px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>شماره فنی</th>
                                    <th>اصلی موجود</th>
                                    <th>کپی موجود</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($row['goods'] as $key => $element) :
                                    $original_limit = $element['original'];
                                    $fake = $element['fake'] ?>
                                    <tr>
                                        <td class="cell-code"><?= $counter ?></td>
                                        <td class="cell-code "><?= getPartNumber($key) ?></td>
                                        <td class="cell-qty "><?= $original_limit ?></td>
                                        <td class="cell-qty"><?= $fake ?></td>
                                    </tr>
                                <?php
                                    $counter++;
                                endforeach; ?>
                                <tr style="background-color: #fea901;">
                                    <td rowspan="2" style=" writing-mode: vertical-lr;">
                                        <small class="bold" style="text-orientation: mixed !important; font-size:12px">
                                            توضیحات
                                        </small>
                                    </td>
                                    <td class="bold" rowspan="2">
                                        <?= $isSingle ? getPartNumber($key) : getRelationInfo($index); ?></td>
                                    <td class="bold" style="background-color: <?= $sumOriginal < $original  ? 'red' :  'green' ?>;">
                                        موجود :
                                        <?= $sumOriginal ?>
                                    </td>
                                    <td class="bold" style="background-color: <?= $fakeNeed > $sumFake ? 'red' :  'green' ?>;">
                                        موجود:
                                        <?= $sumFake ?>
                                    </td>
                                </tr>
                                <tr style="background-color: #fea901;">
                                    <td class="bold" style="background-color: <?= $original <= $sumOriginal ? 'green' : 'red' ?>;">
                                        مورد نیاز:
                                        <?= $original ?>
                                    </td>
                                    <td class="bold" style="background-color: <?= $fakeNeed > $sumFake ? 'red' :  'green' ?>;">
                                        مورد نیاز:
                                        <?= $fakeNeed ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php

                    endforeach;
                    ?>
                </div>
                <div id="two">
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once("./views/Layout/footer.php") ?>