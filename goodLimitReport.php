<?php
include("header.php");
include './php/limit-report-getter.php';
?>
<style>
    .wrapper {
        width: 90%;
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
<script>
    let j = jQuery.noConflict();
    j(document).ready(function() {
        let tabs = j(".tabs li a");
        tabs.click(function() {
            let content = this.hash.replace("/", "");
            tabs.removeClass("active");
            j(this).addClass("active");
            j("#content").find("div").hide();
            j(content).fadeIn(200);
        });
    });
</script>
<div>
    <div>
        <div class="wrapper">
            <ul class="tabs group">
                <li>
                    <a class="orange-border active" href="#/one">
                        تک آیتم ها
                        <span class="badge">5</span>
                    </a>
                </li>
                <li>
                    <a class="green-border" href="#/two">
                        رابطه ها
                        <span class="badge">10</span>
                    </a>
                </li>
            </ul>
            <div id="content">
                <div id="one">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>شماره فنی</th>
                                <th>تعداد اصلی مورد نیاز</th>
                                <th>تعداد کپی مورد نیاز</th>
                                <th>اصلی موجود</th>
                                <th>کپی موجود</th>
                            </tr>
                        </thead>
                        <tbody id="mojodiResult" class="mojodi-table">
                            <?php
                            foreach ($records as $index => $row) :
                                $pattern_id = $row['pattern_id'];
                                $original_limit = $row['original'];
                                $fake = $row['fake'];

                                $existing_record = $existing[$pattern_id];
                                if ($original_limit > $existing_record['original'] || $fake > $existing_record['fake']) : ?>
                                    <tr>
                                        <td class="cell-shakhes "><?= $index + 1 ?></td>
                                        <td class="cell-code "><?= $row["pattern_id"] ?></td>
                                        <td class="cell-qty "><?= $original_limit ?></td>
                                        <td class="cell-qty"><?= $fake ?></td>
                                        <td class="cell-qty "><?= $existing_record['original'] ?></td>
                                        <td class="cell-qty "><?= $existing_record['fake'] ?></td>
                                    </tr>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="two">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>شماره فنی</th>
                                <th>تعداد اصلی مورد نیاز</th>
                                <th>تعداد کپی مورد نیاز</th>
                                <th>اصلی موجود</th>
                                <th>کپی موجود</th>
                            </tr>
                        </thead>
                        <tbody id="mojodiResult" class="mojodi-table">
                            <?php
                            foreach ($records as $index => $row) :
                                $nisha_id = $row['nisha_id'];
                                $original_limit = $row['original'];
                                $fake = $row['fake'];

                                $existing_record = $existing[$nisha_id];
                                if ($original_limit > $existing_record['original'] || $fake > $existing_record['fake']) : ?>
                                    <tr>
                                        <td class="cell-shakhes "><?= $index + 1 ?></td>
                                        <td class="cell-code "><?= $row["nisha_id"] ?></td>
                                        <td class="cell-qty "><?= $original_limit ?></td>
                                        <td class="cell-qty"><?= $fake ?></td>
                                        <td class="cell-qty "><?= $existing_record['original'] ?></td>
                                        <td class="cell-qty "><?= $existing_record['fake'] ?></td>
                                    </tr>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include("footer.php") ?>