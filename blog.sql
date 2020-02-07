/*
Navicat Premium Data Transfer

Source Server         : blog
Source Server Type    : MySQL
Source Server Version : 80012
Source Host           : localhost:3306
Source Schema         : blog

Target Server Type    : MySQL
Target Server Version : 80012
File Encoding         : 65001

Date: 07/02/2020 16:30:14
 */
SET
  NAMES utf8mb4;

SET
  FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for blog_annoucement
-- ----------------------------
DROP TABLE IF EXISTS `blog_annoucement`;

CREATE TABLE `blog_annoucement` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '公告id',
  `announcement_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告内容',
  `announcement_at` int(255) NOT NULL COMMENT '公告时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_article`;

CREATE TABLE `blog_article` (
  `article_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态，1为正常，0为违规',
  `top` tinyint(4) NOT NULL DEFAULT 0 COMMENT '置顶标记',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `praise_count` int(11) NOT NULL DEFAULT 0 COMMENT '获得的赞的数量',
  `comment_count` int(11) NOT NULL DEFAULT 0 COMMENT '评论的数量',
  `created_at` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `updated_at` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `category_id` int(10) UNSIGNED NOT NULL COMMENT '分类id',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  PRIMARY KEY (`article_id`) USING BTREE,
  INDEX `fk_blog_post_blog_category_idx`(`category_id`) USING BTREE,
  INDEX `fk_blog_post_blog_user1_idx`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_category
-- ----------------------------
DROP TABLE IF EXISTS `blog_category`;

CREATE TABLE `blog_category` (
  `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类名称',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态',
  `posts` int(11) NOT NULL DEFAULT 0 COMMENT '文章数',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  PRIMARY KEY (`category_id`) USING BTREE,
  INDEX `fk_blog_category_blog_user1_idx`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_collect
-- ----------------------------
DROP TABLE IF EXISTS `blog_collect`;

CREATE TABLE `blog_collect` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_comment
-- ----------------------------
DROP TABLE IF EXISTS `blog_comment`;

CREATE TABLE `blog_comment` (
  `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` varchar(140) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论内容',
  `created_at` int(11) NOT NULL COMMENT '评论时间',
  `article_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`comment_id`) USING BTREE,
  INDEX `fk_blog_comment_blog_post1_idx`(`article_id`) USING BTREE,
  INDEX `fk_blog_comment_blog_user1_idx`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_praise
-- ----------------------------
DROP TABLE IF EXISTS `blog_praise`;

CREATE TABLE `blog_praise` (
  `article_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`article_id`, `user_id`) USING BTREE,
  INDEX `fk_table1_blog_user1_idx`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_share
-- ----------------------------
DROP TABLE IF EXISTS `blog_share`;

CREATE TABLE `blog_share` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `article_id` int(11) NOT NULL COMMENT '文章id',
  `share_time` int(11) NULL DEFAULT NULL COMMENT '分享的时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blog_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;

CREATE TABLE `blog_user` (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `role` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '角色，默认是1，普通用户',
  `created_at` int(11) NOT NULL COMMENT '注册时间',
  `information` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '管理员的私信',
  `article_num` int(11) NULL DEFAULT NULL,
  `follows_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '关注数量',
  `fans_id` int(11) NULL DEFAULT NULL COMMENT '粉丝数量',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `username_UNIQUE`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET
  FOREIGN_KEY_CHECKS = 1;