<div class="container-fluid bg-blue mainvh-height">
    <div class="container px-0" id="topic_list_page">
        <!-- <div class="bredcum-holder m-0 py-3">
            <a href="#" class="text-white">Home /</a>
            <a href="#" class="text-white">Topics</a>
        </div> -->
        <h3 class="title text-white pt-4">Topics</h3>
        <!-- <?php
        // $category = [
        //     0 => 'akash',
        //     1 => 'home',
        //     2 => 'office',
        // ];
        // $data = [
        //     'akash' => [
        //         0 => 'akash',
        //         1 => 'akash',
        //         2 => 'akash',
        //     ],
        //     'home' => [
        //         0 => 'home',
        //         1 => 'home',
        //         2 => 'home',
        //     ],
        //     'office' => [
        //         0 => 'office',
        //         1 => 'office',
        //         2 => 'office',
        //     ]
        //         ]
        ?> -->

        <div class="w-100">
            <ul class="nav nav-pills mb-3 theme-nav" id="pills-tab" role="tablist">
                <?php
                if (!empty($category)) {

                    foreach ($category as $key => $value) {
                        if (!$key) {
                            echo '
                <li class="nav-item">
                <a class="nav-link active" id="pills-' . $value . '-tab" data-toggle="pill" href="#pills-' . $value . '" role="tab" aria-selected="true">' . $value . '</a>
                </li>';
                        } else {
                            if ($value)
                                echo '
                <li class="nav-item">
                <a class="nav-link" id="pills-' . $value . '-tab" data-toggle="pill" href="#pills-' . $value . '" role="tab" aria-selected="true">' . $value . '</a>
                </li>';
                        }
                    }
                }
                ?>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <?php
                if (!empty($category) && !empty($topics)) {

                    foreach ($category as $key => $value) {
                        if (!$key) {
                            echo '
                            <div class="tab-pane fade show active" id="pills-' . $value . '" role="tabpanel" aria-labelledby="pills-' . $value . '-tab">
                            <div class="topic-holder topics-list">';

                            foreach ($topics[$value] as $v) {
                                echo'<a href="' . base_url() . "games/" . $v['id'] . '" class="topic text-decoration-none">
                            <img src="' . $v['image'] . '"/ alt="'.$v['topic'].'">
                            <h6>' . $v['topic'] . '</h6>
                        </a>';
                            }
                            $btn = '';
                            $get_topic_limt = get_topic_limt();
                            if (((count($topics[$value]) + 1) > $get_topic_limt)) {
                                $btn = '<button class="btn button-plan-bg text-white my-4 all-topics" data-offset="' . get_topic_limt() . '">Load More</button>';
                            }
                            echo'</div><center>' . $btn . '</center></div>';
                        } else {
                            if ($topics[$value])
                                echo '
                            <div class="tab-pane fade" id="pills-' . $value . '" role="tabpanel" aria-labelledby="pills-' . $value . '-tab">
                            <div class="topic-holder topics-category-list">';

                            foreach ($topics[$value] as $e) {
                                echo'<a href="' . base_url() . "games/" . $e['id'] . '" class="topic text-decoration-none">
                                <img src="' . $e['image'] . '"/ alt="'.$e['topic'] .'">
                                <h6>' . $e['topic'] . '</h6>
                        </a>';
                            }
                            echo'</div><center><button class="btn button-plan-bg text-white my-4 category-topics" data-offset="' . get_topic_limt() . '" data-cat="' . $main_category . '">Load More</button></center></div>';
                        }
                    }
                }
                ?>

            </div>
        </div>



    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        active_second();

        var main_offset = parseInt(" <?php echo get_topic_limt() ?>");
        $('.all-topics').click(function () {
            var offset = $(this).data('offset');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('topic/gettopics'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset},
                success: function (data) {
                    if (data.length == 0) {
                        $('.all-topics').hide();
                    } else {
                        if (data.length < main_offset) {
                            $('.all-topics').hide();
                        }
                        add_topic('topics-list', data);
                    }
                }
            });
        });

        $('.category-topics').click(function () {
            var offset = $(this).data('offset');
            var category = $(this).data('cat');
            $(this).data('offset', offset + main_offset)
            $.ajax({
                url: "<?= base_url('topic/gettopics'); ?>",
                type: "POST",
                dataType: 'JSON',
                data: {offset: offset, category: category},
                success: function (data) {
                    if (data.length == 0) {
                        $('.category-topics').hide();
                    } else {
                        if (data.length < main_offset) {
                            $('.category-topics').hide();
                        }
                        add_topic('topics-category-list', data);
                    }
                }
            });
        });

        function add_topic(selector, data) {
            var div = "";
            console.log(data);
            $.each(data, function (key, value) {
                div += "<a href=" + base_url + "games/" + value.id + " class='topic text-decoration-none'>";
                div += "<img src=" + value.image + " />";
                div += "<h6>" + value.topic + "</h6>";
                div += "</a>";
            });

            $('.' + selector).append(div);
        }
    });
</script>
