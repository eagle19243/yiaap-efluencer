<link rel="stylesheet" href="<?php echo ASSETS; ?>plugins/taginput/tokenize2.min.css" type="text/css"/>
<script src="<?php echo ASSETS; ?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>

<?php
if (isset($category)) {
  $cat = $category = str_replace('%20', ' ', $category);
  $cate = explode("-", $category);
  $parentc = array();
  foreach ($cate as $rw) {
    $pcat = $this->auto_model->getFeild('parent_id', 'categories', 'cat_name', $rw);
    $parentc[] = $pcat;
  }
} else {
  $parentc = array();
  $cat = 'All';
}
if (isset($project_type)) {
  $ptype = $project_type;
} else {
  $ptype = 'All';
}
if (isset($min_budget)) {
  $minb = $min_budget;
} else {
  $minb = '0';
}
if (isset($max_budget)) {
  $maxb = $max_budget;
} else {
  $maxb = '0';
}
if (isset($posted)) {
  $post_with = $posted;
} else {
  $post_with = 'All';
}
if (isset($country)) {
  $coun = $country;
} else {
  $coun = 'All';
}
if (isset($city)) {
  $ct = $city;
} else {
  $ct = 'All';
}
if (isset($featured)) {
  $featured = $featured;
} else {
  $featured = 'All';
}
if (isset($environment)) {
  $environment = $environment;
} else {
  $environment = 'All';
}
if (isset($uid)) {
  $uid = $uid;
} else {
  $uid = '0';
}
$user = $this->session->userdata('user');
$lang = $this->session->userdata('lang');
?>

<?php //echo $breadcrumb;?>
<section class="sec secFindJob">
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <h2 class="title">Find Job</h2>
            </div>
            <div class="col-md-8">

                <div class="searchbox">

                    <form id="srchForm">
                        <input type="hidden" name="append_skill"
                               value="<?php echo $srch_param['append_skill'] == 1 ? $srch_param['append_skill'] : 0; ?>"/>


                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" name="term"
                                   placeholder="<?php echo __('findjob_search_job_by_title', 'Search job by title'); ?>..."
                                   autocomplete="off"
                                   value="<?php echo !empty($srch_param['term']) ? $srch_param['term'] : ''; ?>">
                            <span class="input-group-addon" id="basic-addon1">
      <button type="submit" class="btn btn-site"><?php echo __('search', 'Search'); ?></button>
      </span>
                        </div>
                        <div class="input-group advanced-search">
                            Advanced Search
                        </div>
                        <div class="spacer-10"></div>
                        <div class="advanced-form form-group" style="display: none">
                            <select class="form-control inputtag" name="skills[]" multiple>
                              <?php if (count($selected_skills) > 0) {
                                foreach ($selected_skills as $k => $v) { ?>
                                    <option value="<?php echo $v['id']; ?>"
                                            selected="selected"><?php echo $v['skill_name']; ?></option>
                                <?php }
                              } ?>
                            </select>
                        </div>

                    </form>
                    <p class="text-right" style="display:none;"><a
                                style="cursor: pointer;"><?php echo __('findjob_advance_search', 'Advanced Search'); ?></a>
                    </p>
                </div>
              <?php if (!empty($srch_param['category']) || !empty($srch_param['sub_catgory'])) { ?>
                  <div class="skill_search">

                    <?php if (!empty($srch_param) && !empty($srch_param['category']) && !empty($srch_param['category_id'])) {
                      $catagory_name = getField('cat_name', 'categories', 'cat_id', $srch_param['category_id']);
                      $arabic_catagory_name = getField('arabic_cat_name', 'categories', 'cat_id', $srch_param['category_id']);
                      $spanish_catagory_name = getField('spanish_cat_name', 'categories', 'cat_id', $srch_param['category_id']);
                      $swedish_catagory_name = getField('swedish_cat_name', 'categories', 'cat_id', $srch_param['category_id']);

                      switch ($lang) {
                        case 'arabic':
                          $categoryName = !empty($arabic_catagory_name) ? $arabic_catagory_name : $catagory_name;
                          break;
                        case 'spanish':
                          //$categoryName = $val['spanish_cat_name'];
                          $categoryName = !empty($spanish_catagory_name) ? $spanish_catagory_name : $catagory_name;
                          break;
                        case 'swedish':
                          //$categoryName = $val['swedish_cat_name'];

                          $categoryName = !empty($swedish_catagory_name) ? $swedish_catagory_name : $catagory_name;
                          break;
                        default :
                          $categoryName = $catagory_name;
                          break;
                      }

                      ?>
                        <span class="chip">
   <?php echo !empty($categoryName) ? $categoryName : ''; ?>
                            <a href="<?php echo base_url('findjob/browse'); ?>"><i class="zmdi zmdi-close"></i></a>
</span>
                    <?php } ?>

                    <?php if (!empty($srch_param) && !empty($srch_param['sub_catgory']) && !empty($srch_param['sub_catgory_id'])) {
                      $sub_catagory_name = getField('cat_name', 'categories', 'cat_id', $srch_param['sub_catgory_id']);
                      $sub_arabic_catagory_name = getField('arabic_cat_name', 'categories', 'cat_id', $srch_param['sub_catgory_id']);
                      $sub_spanish_catagory_name = getField('spanish_cat_name', 'categories', 'cat_id', $srch_param['sub_catgory_id']);
                      $sub_swedish_catagory_name = getField('swedish_cat_name', 'categories', 'cat_id', $srch_param['sub_catgory_id']);

                      switch ($lang) {
                        case 'arabic':
                          $sub_categoryName = !empty($sub_arabic_catagory_name) ? $sub_arabic_catagory_name : $sub_catagory_name;
                          break;
                        case 'spanish':
                          //$categoryName = $val['spanish_cat_name'];
                          $sub_categoryName = !empty($sub_spanish_catagory_name) ? $sub_spanish_catagory_name : $sub_catagory_name;
                          break;
                        case 'swedish':
                          //$categoryName = $val['swedish_cat_name'];

                          $sub_categoryName = !empty($sub_swedish_catagory_name) ? $sub_swedish_catagory_name : $sub_catagory_name;
                          break;
                        default :
                          $sub_categoryName = $sub_catagory_name;
                          break;
                      }

                      ?>
                      <?php // echo 'Sub Category: '; ?>
                        <span class="chip">
  <?php echo __('findjob_sidebar_sub_category', 'Sub Category'); ?> <?php echo !empty($sub_categoryName) ? $sub_categoryName : ''; ?>
                            <a href="<?php echo base_url('findjob/browse') . '/' . $srch_param['category'] . '/' . $srch_param['category_id']; ?>"><i
                                        class="zmdi zmdi-close"></i></a>
</span>
                    <?php } ?>

                  </div>
              <?php } ?>
            </div>


        </div>


        <div class="row">
          <?php $this->load->view('left_sidebar'); ?>
            <aside class="col-md-8 col-sm-12 col-xs-12 project-list">
                <div class="topcontrol_box" style="display:none">
                    <div class="topcbott"></div>
                    <!-- <input type="text" class="topcontrol" id="srch" onkeypress="catdtls1(this.id);" placeholder="Enter Job Name to Search"> -->
                </div>
                <span class="panel-title">Jobs</span>
                <!--<span class="found-results">(--> <?php /*echo $total_projects;*/ ?> <!--) result</span>-->


                <div class="listing" id="prjct">
                    <!--<p>() Results found</p>-->

                  <?php
                  if (count($projects) > 0) {
                    foreach ($projects as $key => $val) {

                      $job_url = VPATH . "jobdetails/details/" . $val['project_id'] . "/" . $this->auto_model->getcleanurl(htmlentities($val['title'])) . "/";
                      ?>
                        <div class="listBox" data-job-url="<?php echo $job_url; ?>">
                          <?php
                          if ($val['featured'] == 'Y') {
                            ?>
                              <div class="featuredimg">
                                <?php
                                $curr_lang = $this->session->userdata('lang');
                                if ($curr_lang == 'arabic') {
                                  $featured_icon = 'featured_ar.png';
                                } else {
                                  $featured_icon = 'featured.png';
                                }
                                ?>
                                  <img src="<?php echo VPATH; ?>assets/images/<?php echo $featured_icon; ?>" alt=""
                                       title="<?php echo __('findjob_featured', 'Featured'); ?>">
                              </div>
                          <?php } ?>
                            <h4 class="designation"><a
                                        href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl(htmlentities($val['title'])); ?>/"><?php echo ucwords(htmlentities($val['title'])); ?> </a>
                            </h4>
                          <?php
                          if ($val['visibility_mode'] == 'Private') {
                            ?>
                              <input type="button" value="Private: bidding by invitation only" class="logbtn2" name="tt"
                                     style="float:right;margin-right: 50%;margin-top: -4%;">
                            <?php
                          }
                          ?>
                            <div class="addthis_sharing_toolbox hidden"
                                 data-url="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>"
                                 style="float: right;margin-top: -30px;margin-right: 12px;"></div>
                            <div class="addthis_sharing_toolbox hidden"
                                 data-url="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>"
                                 style="float: right;margin-top: -30px;margin-right: 12px;"></div>
                            <p class="bio">
                              <?php
                              if ($val['project_type'] == 'F') {
                                echo __('findjob_fixed', 'Fixed');
                              } else {
                                echo __('findjob_hourly', 'Hourly');
                              } ?>
                              <?php echo __('findjob_price', 'Price'); ?>
                                : <?php echo __('findjob_between', 'Between'); ?> <?php echo CURRENCY; ?> <?php echo $val['buget_min']; ?> <?php echo __('findjob_and', 'and'); ?> <?php echo CURRENCY; ?> <?php echo $val['buget_max']; ?>
                                - <?php echo __('findjob_posted', 'Posted'); ?>
                                <b><?php echo __(strtolower(date('M', strtotime($val['post_date']))), date('M', strtotime($val['post_date']))) . ' ' . date('d', strtotime($val['post_date'])) . ',' . date('Y', strtotime($val['post_date'])); ?></b>
                            </p>
                          <?php
                          $totalbid = $this->jobdetails_model->gettotalbid($val['project_id']);
                          ?>
                            <p><b><?php echo $totalbid; ?></b> <?php echo __('findjob_proposals', 'Proposals'); ?></p>
                          <?php
                          //////////////////////For Email/////////////////////////////
                          $pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
                          $replacement = "[*****]";
                          $val['description'] = htmlentities($val['description']);
                          $val['description'] = preg_replace($pattern, $replacement, $val['description']);
                          /////////////////////Email End//////////////////////////////////

                          //////////////////////////For URL//////////////////////////////
                          $pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
                          $replacement = "[*****]";
                          $val['description'] = preg_replace($pattern, $replacement, $val['description']);
                          /////////////////////////URL End///////////////////////////////

                          /////////////////////////For Bad Words////////////////////////////
                          $healthy = explode(",", BAD_WORDS);
                          $yummy = array("[*****]");
                          $val['description'] = str_replace($healthy, $yummy, $val['description']);

                          /////////////////////////Bad Words End////////////////////////////

                          /******************** For Mobile ***************************/

                          $pattern = "/(?:1-?)?(?:\(\d{3}\)|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}/x";
                          $replacement = "[*****]";
                          $val['description'] = preg_replace($pattern, $replacement, $val['description']);

                          /********************  Mobile End ***************************/
                          ?>
                            <p><?php echo substr($val['description'], 0, 250); ?> ... <a
                                        href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl(htmlentities($val['title'])); ?>/"><?php echo __('findjob_more', 'more'); ?></a>
                            </p>

                          <?php
                          $q = array(
                            'select' => 's.skill_name,s.arabic_skill_name,s.spanish_skill_name,s.swedish_skill_name , s.id',
                            'from'   => 'project_skill ps',
                            'join'   => array(array('skills s', 'ps.skill_id = s.id', 'INNER')),
                            'offset' => 200,
                            'where'  => array('ps.project_id' => $val['project_id'])
                          );
                          $skills = get_results($q);


                          ?>
                            <ul class="skills">
                                <li><?php echo __('findjob_skills', 'Skills'); ?>:</li>
                              <?php
                              foreach ($skills as $k => $v) {
                                $skill_name = $v['skill_name'];
                                switch ($lang) {
                                  case 'arabic':
                                    $skill_name = !empty($v['arabic_skill_name']) ? $v['arabic_skill_name'] : $v['skill_name'];
                                    break;
                                  case 'spanish':
                                    //$categoryName = $val['spanish_cat_name'];
                                    $skill_name = !empty($v['spanish_skill_name']) ? $v['spanish_skill_name'] : $v['skill_name'];
                                    break;
                                  case 'swedish':
                                    //$categoryName = $val['swedish_cat_name'];

                                    $skill_name = !empty($v['swedish_skill_name']) ? $v['swedish_skill_name'] : $v['skill_name'];
                                    break;
                                  default :
                                    $skill_name = $v['skill_name'];
                                    break;
                                }
                                ?>
                                  <li><a href="javascript:void(0);"><?php echo $skill_name; ?></a></li>
                              <?php } ?>
                            </ul>
                          <?php
                          if ($cat != 'All') {
                            if (in_array($val['category'], $cate)) {
                              $lnki = $category;
                            } else {
                              $lnki = $category . "-" . $val['category'];
                            }
                          } else {
                            $lnki = $val['category'];
                          }
                          if (is_numeric($val['sub_category'])) {
                            $sub_category_name = $this->auto_model->getFeild('cat_name', 'categories', 'cat_id', $val['sub_category']);
                            $arabic_sub_category_name = $this->auto_model->getFeild('arabic_cat_name', 'categories', 'cat_id', $val['sub_category']);
                            $spanish_sub_category_name = $this->auto_model->getFeild('spanish_cat_name', 'categories', 'cat_id', $val['sub_category']);
                            $swedish_sub_category_name = $this->auto_model->getFeild('swedish_cat_name', 'categories', 'cat_id', $val['sub_category']);
                            switch ($lang) {
                              case 'arabic':
                                $val['sub_category_name'] = !empty($arabic_sub_category_name) ? $arabic_sub_category_name : $sub_category_name;
                                break;
                              case 'spanish':
                                //$categoryName = $val['spanish_cat_name'];
                                $val['sub_category_name'] = !empty($spanish_sub_category_name) ? $spanish_sub_category_name : $sub_category_name;
                                break;
                              case 'swedish':
                                //$categoryName = $val['swedish_cat_name'];

                                $val['sub_category_name'] = !empty($swedish_sub_category_name) ? $swedish_sub_category_name : $sub_category_name;
                                break;
                              default :
                                $val['sub_category_name'] = $sub_category_name;
                                break;
                            }
                          } else {
                            $val['sub_category_name'] = $val['sub_category'];
                          }

                          $par_cat = $this->auto_model->getFeild('cat_name', 'categories', 'cat_id', $val['category']);
                          ?>
                            <p class="mar-top hidden"><?php echo __('findjob_category', 'Category'); ?><span>: <a
                                            href="<?php echo base_url('findjob/browse') . '/' . $this->auto_model->getcleanurl($par_cat) . '/' . $val['category'] . '/' . $this->auto_model->getcleanurl($val['sub_category_name']) . '/' . $val['sub_category']; ?>"><?php echo $val['sub_category_name']; ?></a> </span>
                            </p>
                            <p>
                              <?php echo __('findjob_posted_by', 'Posted by'); ?>: <a style=" color: #205691;text-decoration: none;
"
                                                                                      href="<?php echo VPATH; ?>clientdetails/showdetails/<?php echo $val['user_id']; ?>"><?php echo $val['fname'] . ' ' . $val['lname'] ?></a>,<?php if ($val['user_city'] != "" and is_numeric($val['user_city'])) {
                                echo "&nbsp;&nbsp;" . getField('Name', 'city', 'id', $val['user_city']) . ", ";
                              } ?>&nbsp;&nbsp;<?php echo getField('Name', 'country', 'Code', $val['country']); ?> &nbsp;&nbsp;
                              <?php
                              $code = strtolower($this->auto_model->getFeild('code2', 'country', 'Code', $val['user_country']));
                              $code = strtolower($this->auto_model->getFeild('code2', 'country', 'Code', $val['country']));
                              ?>
                                <img src="<?php echo VPATH; ?>assets/images/cuntryflag/<?php echo $code; ?>.png"> &nbsp;&nbsp;
                              <?php
                              if ($val['project_type'] == 'F') {
                                ?>
                                  <img src="<?php echo VPATH; ?>assets/images/fixed.png">
                                <?php
                              } else {
                                ?>
                                  <img src="<?php echo VPATH; ?>assets/images/hourly.png">
                                <?php
                              }
                              ?>

                              <?php
                              if ($this->session->userdata('user')) {
                                ?>
                                  <a href="<?php echo VPATH; ?>jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl(htmlentities($val['title'])); ?>/"
                                     class="btn btn-site btn-sm pull-right"><?php echo __('findjob_select_this_job', 'Select this job'); ?></a>
                                <?php
                              } else {
                                ?>
                                  <a href="<?php echo VPATH; ?>login?refer=jobdetails/details/<?php echo $val['project_id']; ?>/<?php echo $this->auto_model->getcleanurl(htmlentities($val['title'])); ?>/"
                                     class="btn btn-site btn-sm pull-right"><?php echo __('findjob_select_this_job', 'Select this job'); ?></a>
                                <?php
                              }
                              ?>
                        </div>
                    <?php }
                  } else {
                    echo "<div class='alert alert-danger'>" . __('findjob_no_jobs_found', 'No jobs found') . "</div>";
                  } ?>


                </div>
                <nav aria-label="Page navigation" id="nav_bar">
                  <?php
                  $user = $this->session->userdata('user');
                  if (isset($user[0]->user_id) && isset($links)) { ?>
                    <?php
                    echo $links;
                    ?>
                    <?php
                  } else {
                    echo "<div class='show-pagination'><a href='".site_url()."login'>Login</a> to see more results</div>";
                  }
                  ?>
                </nav>


            </aside>
        </div>
    </div>
</section>
<div class="clearfix"></div>


<script type="text/javascript">
  function catdtls1(id) {
    var cat = $('#' + id).val();
    if (cat == '') {
      cat = '_';
    }
    //alert(cat);
    var category = '<?php echo str_replace('&', '_', $cat);?>';
    //alert(category);die():
    var ptype = '<?php echo $ptype;?>';
    var minb = '<?php echo $minb;?>';
    var maxb = '<?php echo $maxb;?>';
    var post_with = '<?php echo $post_with;?>';
    var coun = '<?php echo $coun;?>';
    var ct = '<?php echo $ct;?>';
    var featured = '<?php echo $featured;?>';
    var environment = '<?php echo $environment;?>';
    var uid = '<?php echo $uid;?>';

    var dataString = 'cid=' + cat + '&category=' + category + '&ptype=' + ptype + '&minb=' + minb + '&maxb=' + maxb + '&post_with=' + post_with + '&coun=' + coun + '&ct=' + ct + '&featured=' + featured + '&environment=' + environment;
    $.ajax({
      type: "POST",
      data: dataString,
      url: "<?php echo base_url();?>findjob/getsrch/" + cat + "/" + category + "/" + ptype + "/" + minb + "/" + maxb + "/" + post_with + "/" + coun + "/" + ct + "/" + featured + "/" + environment,
      success: function (return_data) {
        $("#pagi").hide();
        //alert(return_data);
        $('#prjct').html('');
        $('#prjct').html(return_data);
        $('#nav_bar').hide();
      }
    });
  }

  $('.inputtag').tokenize2({
    placeholder: "<?php echo __('findjob_select_a_skill', 'Select a Skill'); ?>",
    dataSource: function (search, object) {
      $.ajax({
        url: '<?php echo base_url('contest/get_skills')?>',
        data: {search: search},
        dataType: 'json',
        success: function (data) {
          var $items = [];
          $.each(data, function (k, v) {
            $items.push(v);
          });
          object.trigger('tokenize:dropdown:fill', [$items]);
        }
      });
    }
  });

  $('.inputtag').on('tokenize:tokens:add', function (o) {
    $('#srchForm').submit();
  });

  $('.inputtag').on('tokenize:tokens:remove', function (o) {
    $('#srchForm').find('[name="append_skill"]').val(0);
    $('#srchForm').submit();
  });
  // show advance search
  $('.advanced-search').click(function () {
    $('.advanced-form').toggle('slow');
  });

  if ((location.href).indexOf('&skills') !== -1) {
    $('.advanced-form').show();
  }


</script>


