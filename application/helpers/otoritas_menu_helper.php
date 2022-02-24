<?php
defined('BASEPATH') or exit('No direct script access allowed');

// NOTE Load Akses Menu Wuling
function load_akses_wuling()
{
    $CI = &get_instance();
    $id_user = $CI->session->userdata('id_user');
    $CI->db_wuling_as->select('*');
    $CI->db_wuling_as->from('after_sales_users as');
    $CI->db_wuling_as->where('id_users', $id_user);
    $data = $CI->db_wuling_as->get();
    foreach ($data->result() as $row) {
        $access = $row->access;
    }
    $data_menu = explode(",", $access);
    return $data_menu;
}

// NOTE Menu
function open_parent_head($icon, $text_menu)
{
    $html = '<ul class="nav nav-list">
      <li>
          <a href="" class="dropdown-toggle">
              <i class="' . $icon . '"></i>
              <span class="menu-text"> ' . $text_menu . ' </span>
              <b class="arrow icon-angle-down"></b>
          </a>
          <ul class="submenu">';
    return $html;
}

function open_parent_head_sales($icon, $text_menu)
{
    $html = '<ul data-menu="menu-navigation" class="navigation navigation-main">
      <li class=" nav-item">
          <a href="" class="">
              <i class="' . $icon . '"></i>
              <span class="menu-text"> ' . $text_menu . ' </span>
              
          </a>
          <ul class="menu-content">';
    return $html;
}

function close_parent_head()
{
    $html = '</ul></li></ul>';
    return $html;
}

function open_parent_head_1($text_menu)
{
    $html = '<li>
      <a href="" class="dropdown-toggle">
          <span class="menu-text">' . $text_menu . '</span>
          <b class="arrow icon-angle-down"></b>
      </a>
      <ul class="submenu">';
    return $html;
}

function open_parent_head_1_sales($text_menu)
{
    $html = '<li>
      <a href="" class="">
          <span class="menu-text">' . $text_menu . '</span>
          
      </a>
      <ul class="menu-content">';
    return $html;
}

function close_parent_head_1()
{
    $html = '</ul></li>';
    return $html;
}


/**
 * child
 *
 * @param  mixed $menu_akses daftar menu yg dapat diakses
 * @param  mixed $text_menu text menu
 * @param  mixed $id id menu
 * @param  mixed $class class menu 
 * @param  mixed $url url menu
 * @return void
 */
function child($menu_akses, $text_menu, $id, $class, $url)
{
    if (in_array($id, $menu_akses)) {
        $html = '<li><a href="' . $url . '" class="' . $class . '" id="' . $id . '">' . $text_menu . '</a></li>';
    } else {
        $html = null;
    }
    return $html;
}

function child_sales($menu_akses, $text_menu, $id, $class, $url)
{
    if (in_array($id, $menu_akses)) {
        $html = '<li class="' . $class . '" id="' . $id . '"><a href="' . $url . '" id="' . $id . '">' . $text_menu . '</a></li>';
    } else {
        $html = null;
    }
    return $html;
}

// NOTE Create Users
function open_parent_head_new($null, $text_menu)
{
    $html = '<li>' . $text_menu . '
      <ul>';
    return $html;
}
function close_parent_head_new()
{
    $html = '</ul></li>';
    return $html;
}
function open_parent_head_new_1($text_menu)
{
    $html = '<li>' . $text_menu . '
      <ul>';
    return $html;
}
function close_parent_head_new_1()
{
    $html = '</ul></li>';
    return $html;
}
function child_new($null, $text_menu, $id, $null1)
{
    $html = '<li id="' . $id . '">' . $text_menu . '</li>';
    return $html;
}

// NOTE Edit 
function open_parent_head_edit($null, $text_menu)
{
    $html = '<li>' . $text_menu . '
      <ul>';
    return $html;
}
function close_parent_head_edit()
{
    $html = '</ul></li>';
    return $html;
}
function open_parent_head_edit_1($text_menu)
{
    $html = '<li>' . $text_menu . '
      <ul>';
    return $html;
}
function close_parent_head_edit_1()
{
    $html = '</ul></li>';
    return $html;
}
// NOTE Validasi dan Menarik data Hak Akses Users
function akses_menu($menu_akses, $data_menu)
{
    if (in_array($data_menu, $menu_akses)) {
        $result = "data-checkstate='checked'";
    } else {
        $result =  "";
    }
    return $result;
}
function child_edit($menu_akses, $text_menu, $id, $null1)
{
    if (in_array($id, $menu_akses)) {
        $html = '<li data-checkstate="checked" id="' . $id . '">' . $text_menu . '</li>';
    } else {
        $html = '<li id="' . $id . '">' . $text_menu . '</li>';
    }

    return $html;
}


//Menu By Gaza

function single_menu($menu_akses, $icon, $text_menu, $id, $class, $url)
{
    $html = in_array($id, $menu_akses) ? '<li class="' . $class . '"><a href="' . $url . '"><i class="' . $icon . '"></i>
    <span class="menu-title">' . $text_menu . '</span></a></li>' : null;
    return $html;
}
function _header($menu_akses, $text_menu, $id)
{
    $html = in_array($id, $menu_akses) ? '<li class="navigation-header"><span>' . $text_menu . '</span></li>' : null;
    return $html;
}
function open_parent($icon, $text_menu)
{
    $html = '<li class="nav-item"><a href=""><i class="' . $icon . '"></i><span class="menu-title">' . $text_menu . '</span></a>
        <ul class="menu-content">';
    return $html;
}

function close_parent()
{
    return "</ul></li>";
}

function _child($menu_akses, $text_menu, $id, $class, $url)
{
    $html = in_array($id, $menu_akses) ? '<li class="' . $class . '"><a href="' . $url . '" class="menu-item">' . $text_menu . '</a></li>' : null;
    return $html;
}



// Menu Single link
function single_menu_link($menu_akses, $icon, $text_menu, $id, $class, $url)
{
    $html = in_array($id, $menu_akses) ?
        "<li class='". $class ." nav-item'><a href='" . $url . "'><i class=" . $icon . "></i><span data-i18n='nav.dash.main' class='menu-title'>" . $text_menu . "</span></a></li>" : null;
    return $html;
}
