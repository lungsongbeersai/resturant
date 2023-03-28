
function res_group(cate_group,selectID,edit_product_cate_fk){
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?large_group",
        method:"POST",
        data:{selectID},
        success:function(data){
            $("."+cate_group).html(data);
            fixed_select_one(cate_group);
            res_categroy(cate_group,edit_product_cate_fk)
        }
    })
}

function res_branch(product_branch,selectID){
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?branch",
        method:"POST",
        data:{selectID},
        success:function(data){
            $("."+product_branch).html(data);
            fixed_select_one(product_branch);
        }
    })
}

function res_expenses_type(exp_type_fk,selectID){
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?uniteType",
        method:"POST",
        data:{selectID},
        success:function(data){
            $("."+exp_type_fk).html(data);
            fixed_select_one(exp_type_fk);
        }
    })
}

function res_table(table_zone_fk,selectID){
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?table_list",
        method:"POST",
        data:{selectID},
        success:function(data){
            $(".table_zone_fk").html(data);
            fixed_select_one(table_zone_fk);
        }
    })
}

function res_categroy(cate_group,selectID){
    var cate_group=$("."+cate_group).val();
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?categroy",
        method:"POST",
        data:{cate_group,selectID},
        success:function(data){
            $("#product_cate_fk").html(data);
            fixed_select_one("product_cate_fk");
        }
    })
}

function res_categroy(cate_group,selectID){
    var cate_group=$("."+cate_group).val();
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?categroy",
        method:"POST",
        data:{cate_group,selectID},
        success:function(data){
            $("#product_cate_fk").html(data);
            fixed_select_one("product_cate_fk");
        }
    })
}

function res_userlogin(loginID,selectID){
    var loginID=$("."+loginID).val();
    $.ajax({
        url:"services/sql/service-all.php?getloginID",
        method:"POST",
        data:{loginID},
        success:function(data){
            $(".menu_default_code").html(data);
            fixed_select_one(selectID);
        }
    })
}

function res_status(user_permission_fk){
    $.ajax({
        url:"services/sql/service-all.php?permission",
        method:"POST",
        success:function(data){
            $("."+user_permission_fk).html(data);
        }
    })
}

function res_unite(product_unite_fk,selectID){
    var product_unite_fk=$("."+product_unite_fk).val();
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?unite",
        method:"POST",
        data:{product_unite_fk,selectID},
        success:function(data){
            $(".product_unite_fk").html(data);
            fixed_select_one("product_unite_fk");
        }
    })
}

function res_store(storeID){
    $.ajax({
        url:"services/sql/service-all.php?store",
        method:"POST",
        success:function(data){
            $("."+storeID).html(data);
            fixed_select_one(storeID);
            var storeCode=$("."+storeID).val();
            $.ajax({
                url:"services/sql/service-all.php?branchUrl",
                method:"POST",
                data:{storeCode},
                success:function(data1){
                    $(".branch_code").html(data1);
                    fixed_select_one("branch_code");
                    var branch_code=$(".branch_code").val();
                    $.ajax({
                        url:"services/sql/service-all.php?productUrl",
                        method:"POST",
                        data:{branch_code},
                        success:function(data2){
                            $(".promo_product_fk").html(data2);
                            fixed_select_one("promo_product_fk");
                        }
                    })
                }
            })
        }
    })
}

function changeProduct(branch_code){
    var branch_code=$("."+branch_code).val();
    $.ajax({
        url:"services/sql/service-all.php?productUrl",
        method:"POST",
        data:{branch_code},
        success:function(data2){
            $(".promo_product_fk").html(data2);
            fixed_select_one("promo_product_fk");
        }
    })
}

function res_storeSearch(storeID){
    $.ajax({
        url:"services/sql/service-all.php?store",
        method:"POST",
        success:function(data){
            $("."+storeID).html(data);
            res_searchBranch(storeID)
        }
    })
}


function res_searchBranch(storeCode1){
    var storeCode=$("."+storeCode1).val();
    $.ajax({
        url:"services/sql/service-all.php?branchUrl",
        method:"POST",
        data:{storeCode},
        success:function(data1){
            $(".search_branch").html(data1);
        }
    })
}

// function res_store_branch(storeID,branch_code){
//     var storeCode=$("."+storeID).val();
//     alert('11')
//     $.ajax({
//         url:"services/sql/service-all.php?branchUrl",
//         method:"POST",
//         data:{storeCode},
//         success:function(data){
//             $("."+branch_code).html(data);
//             fixed_select_one(branch_code);
//         }
//     })
// }


function res_colors(show_id,selectID){
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?colors",
        method:"POST",
        data:{selectID},
        success:function(data){
            $("."+show_id).html(data);
        }
    })
}

function res_size(show_id,selectID){
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?size",
        method:"POST",
        data:{selectID},
        success:function(data){
            $("."+show_id).html(data);
        }
    })
}

function res_reorder_point(show_id,selectID){
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?reorder_point",
        method:"POST",
        data:{selectID},
        success:function(data){
            $("."+show_id).html(data);
        }
    })
}

function res_products(show_id,selectID){
    var selectID=$("."+selectID).val();
    $.ajax({
        url:"services/sql/service-all.php?products",
        method:"POST",
        data:{selectID},
        success:function(data){
            $("."+show_id).html(data);
        }
    })
}

function res_products_search(show_id){
    var show_id1=$("."+show_id).val();
    $.ajax({
        url:"services/sql/service-all.php?products_search",
        method:"POST",
        data:{show_id1},
        dataType:"json",
        success:function(data){
            if(data.product_code !=""){
                $(".product_branch").val(data.product_branch);
                $(".product_group_fk").val(data.product_group_fk);
                // $(".product_cate_fk").val(data.product_cate_fk);
                $(".product_name").val(data.product_name);
                $(".product_unite_fk").val(data.product_unite_fk);
                if(data.product_images !=""){
                    $("#display_product").attr("src","assets/img/product_home/"+data.product_images);
                }else{
                    $("#display_product").attr("src","assets/img/logo/no.png");
                }
                var product_group_fk=data.product_group_fk;
                var product_cate_fk=data.product_cate_fk;
                var edit_product_cate_fk=$(".edit_product_cate_fk").val();
                $.ajax({
                    url:"services/sql/service-all.php?categroy_check",
                    method:"POST",
                    data:{product_group_fk,product_cate_fk,edit_product_cate_fk},
                    success:function(data){
                        $("#product_cate_fk").html(data);
                    }
                })
                $.ajax({
                    url:"services/sql/service-all.php?products_search_detail",
                    method:"POST",
                    data:{show_id1},
                    success:function(data){
                        $("#show_first").html(data);
                    }
                })
            }
        }
    })
}