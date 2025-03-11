<?php
/**
 * @package DeepSeek_Comment_Reply
 * @version 1.0.0
 * 
 * Plugin Name: DeepSeek Comment Reply
 * Plugin URI:  https://hmcsz.top/index.php/2025/03/04/wordpress%e4%b8%8b%e7%9a%84deepseek-%e8%af%84%e8%ae%ba%e7%b3%bb%e7%bb%9f/
 * Description: Auto-reply WordPress comments via DeepSeek API
 * 
 * Copyright (c) 2025 香山一棵葱 团队 (https://hmcsz.top/index.php/sample-page/)
 * 
 * MIT License: https://opensource.org/license/mit/
 */

// 设置响应编码为 UTF-8
function set_response_encoding() {
    header('Content-Type: text/html; charset=UTF-8');
}

// 设置 PHP 脚本的内存限制和最大执行时间
function set_script_limits() {
    if (!ini_set('memory_limit', '256M')) {
        optimized_error_log('Failed to set memory limit');
    }
    if (!ini_set('max_execution_time', 300)) {
        optimized_error_log('Failed to set max execution time');
    }
}

// 优化日志记录函数
function optimized_error_log($message, $max_length = 1000) {
    if (strlen($message) > $max_length) {
        $message = substr($message, 0, $max_length) . '... [TRUNCATED]';
    }

    // 自定义日志路径
    $log_file = WP_CONTENT_DIR . '/logs/deepseek_comment_system.log';

    // 创建日志目录（如果不存在）
    if (!file_exists(dirname($log_file))) {
        mkdir(dirname($log_file), 0755, true);
    }

    // 日志轮换（最大10MB）
    if (file_exists($log_file) && filesize($log_file) > 10 * 1024 * 1024) {
        $backup_file = $log_file . '.' . date('YmdHis');
        rename($log_file, $backup_file);
    }

    error_log('[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL, 3, $log_file);
}

// 调用设置函数
set_response_encoding();
set_script_limits();

/*
Plugin Name: DeepSeek 评论系统
Plugin URI:  https://hmcsz.top/index.php/2025/03/04/wordpress%e4%b8%8b%e7%9a%84deepseek-%e8%af%84%e8%ae%ba%e7%b3%bb%e7%bb%9f/
Description: 对接DeepSeek自动回复访客评论。务必阅读简介后使用，这是一个轻量级插件。
Version: 1.0.0
Author: 香山一棵葱
Author URI: https://hmcsz.top/index.php/sample-page/
License: GPL2
*/

// 注册设置页面
function deepseek_comment_reply_settings_page() {
    add_options_page(
        'DeepSeek Comment Reply Settings',
        'DeepSeek Comment Reply',
        'manage_options',
        'deepseek-comment-reply-settings',
        'deepseek_comment_reply_settings_page_content'
    );
}
add_action('admin_menu', 'deepseek_comment_reply_settings_page');

// 设置页面内容
function deepseek_comment_reply_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>DeepSeek Comment Reply Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('deepseek_comment_reply_settings_group');
            do_settings_sections('deepseek-comment-reply-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// 注册设置
function deepseek_comment_reply_register_settings() {
    register_setting('deepseek_comment_reply_settings_group', 'deepseek_api_key');
    register_setting('deepseek_comment_reply_settings_group', 'deepseek_api_url');
    register_setting('deepseek_comment_reply_settings_group', 'deepseek_prompt');
    register_setting('deepseek_comment_reply_settings_group', 'deepseek_model_id');
    register_setting('deepseek_comment_reply_settings_group', 'deepseek_bot_user_id');
    register_setting('deepseek_comment_reply_settings_group', 'deepseek_exempt_users');

    add_settings_section(
        'deepseek_comment_reply_api_section',
        'DeepSeek API Settings',
        'deepseek_comment_reply_api_section_callback',
        'deepseek-comment-reply-settings'
    );

    add_settings_field(
        'deepseek_api_key',
        'API Key',
        'deepseek_comment_reply_api_key_callback',
        'deepseek-comment-reply-settings',
        'deepseek_comment_reply_api_section'
    );

    add_settings_field(
        'deepseek_api_url',
        'API URL',
        'deepseek_comment_reply_api_url_callback',
        'deepseek-comment-reply-settings',
        'deepseek_comment_reply_api_section'
    );

    add_settings_field(
        'deepseek_prompt',
        'Prompt',
        'deepseek_comment_reply_prompt_callback',
        'deepseek-comment-reply-settings',
        'deepseek_comment_reply_api_section'
    );

    add_settings_field(
        'deepseek_model_id',
        'Model ID',
        'deepseek_comment_reply_model_id_callback',
        'deepseek-comment-reply-settings',
        'deepseek_comment_reply_api_section'
    );

    add_settings_field(
        'deepseek_bot_user_id',
        '机器人用户ID',
        'deepseek_comment_reply_bot_user_id_callback',
        'deepseek-comment-reply-settings',
        'deepseek_comment_reply_api_section'
    );

    add_settings_field(
        'deepseek_exempt_users',
        '回复豁免者',
        'deepseek_comment_reply_exempt_users_callback',
        'deepseek-comment-reply-settings',
        'deepseek_comment_reply_api_section'
    );
}
add_action('admin_init', 'deepseek_comment_reply_register_settings');

// API设置部分回调
function deepseek_comment_reply_api_section_callback() {
    echo '<p>配置DeepSeek API的相关信息。</p>';
}

// API Key字段回调
function deepseek_comment_reply_api_key_callback() {
    $api_key = get_option('deepseek_api_key');
    echo '<input type="text" name="deepseek_api_key" value="' . esc_attr($api_key) . '" />';
}

// API URL字段回调
function deepseek_comment_reply_api_url_callback() {
    $api_url = get_option('deepseek_api_url');
    echo '<input type="text" name="deepseek_api_url" value="' . esc_attr($api_url) . '" />';
}

// 提示词字段回调
function deepseek_comment_reply_prompt_callback() {
    $prompt = get_option('deepseek_prompt');
    echo '<textarea name="deepseek_prompt" rows="5" cols="50">' . esc_textarea($prompt) . '</textarea>';
}

// Model ID字段回调
function deepseek_comment_reply_model_id_callback() {
    $model_id = get_option('deepseek_model_id');
    echo '<input type="text" name="deepseek_model_id" value="' . esc_attr($model_id) . '" />';
}

// 机器人用户ID字段回调
function deepseek_comment_reply_bot_user_id_callback() {
    $bot_user_id = get_option('deepseek_bot_user_id');
    echo '<input type="text" name="deepseek_bot_user_id" value="' . esc_attr($bot_user_id) . '" />';
}

// 回复豁免者字段回调
function deepseek_comment_reply_exempt_users_callback() {
    $exempt_users = get_option('deepseek_exempt_users');
    echo '<input type="text" name="deepseek_exempt_users" value="' . esc_attr($exempt_users) . '" />';
    echo '<p class="description">输入要豁免的用户ID，多个ID用英文逗号分隔</p>';
}

// 处理新评论并自动回复
function deepseek_comment_reply_on_new_comment($comment_ID, $comment_approved, $commentdata) {
    // 检查评论是否已经处理过
    $is_processed = get_comment_meta($comment_ID, 'deepseek_comment_processed', true);
    if ($is_processed) {
        return;
    }

    // 获取机器人用户 ID
    $bot_user_id = get_option('deepseek_bot_user_id');

    // 检查是否是机器人自己的评论
    if ($commentdata['user_id'] == $bot_user_id) {
        optimized_error_log('检测到机器人自己的评论，跳过处理');
        return;
    }

    // 检查是否是豁免用户
    $exempt_users = get_option('deepseek_exempt_users');
    if ($exempt_users) {
        $exempt_users = array_map('trim', explode(',', $exempt_users));
        if (in_array($commentdata['user_id'], $exempt_users)) {
            optimized_error_log('检测到豁免用户的评论，跳过处理');
            return;
        }
    }

    // 检查是否是对机器人回复的评论
    $parent_comment_id = $commentdata['comment_parent'];
    if ($parent_comment_id) {
        $parent_comment = get_comment($parent_comment_id);
        if ($parent_comment && $parent_comment->user_id == $bot_user_id) {
            optimized_error_log('这是对机器人回复的评论，跳过自动回复');
            return;
        }
    }

    if ($comment_approved == 1) {
        // 设置评论为已处理
        update_comment_meta($comment_ID, 'deepseek_comment_processed', true);

        $api_key = get_option('deepseek_api_key');
        $api_url = get_option('deepseek_api_url');
        $prompt = get_option('deepseek_prompt');
        $model_id = get_option('deepseek_model_id');
        $comment_content = get_comment_text($comment_ID);

        // 验证 API URL
        if (!filter_var($api_url, FILTER_VALIDATE_URL)) {
            optimized_error_log('无效的 API URL: ' . esc_html($api_url));
            return;
        }

        // 处理特殊字符和编码
        $comment_content = htmlspecialchars($comment_content, ENT_QUOTES, 'UTF-8');
        $detected_encoding = mb_detect_encoding($comment_content, ['UTF-8', 'GBK', 'GB2312', 'ISO-8859-1']);
        if ($detected_encoding && $detected_encoding !== 'UTF-8') {
            $comment_content = mb_convert_encoding($comment_content, 'UTF-8', $detected_encoding);
        }

        if (!empty($api_key) && !empty($api_url) && !empty($prompt) && !empty($model_id)) {
            $full_prompt = $prompt . "\n访客评论: " . $comment_content;

            // 构建请求体
            $request_body = [
                "model" => $model_id,
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $full_prompt
                    ]
                ],
                "response_format" => ["type" => "text"]
            ];

            // 安全处理 JSON 编码
            $encoded_request_body = json_encode($request_body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            if (json_last_error() !== JSON_ERROR_NONE) {
                optimized_error_log('JSON 编码失败: ' . json_last_error_msg());
                return;
            }

            $args = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json'
                ],
                'body' => $encoded_request_body,
                'method' => 'POST',
                'timeout' => 300
            ];

            // API 请求重试机制
            $max_retries = 3;
            $retry_count = 0;
            $response = null;

            while ($retry_count < $max_retries) {
                $response = wp_remote_post($api_url . '/chat/completions', $args);

                if (!is_wp_error($response)) {
                    break;
                }

                $retry_count++;
                sleep(1);
            }

            if (is_wp_error($response)) {
                optimized_error_log('API 请求失败: ' . esc_html($response->get_error_message()));
                return;
            }

            $response_code = wp_remote_retrieve_response_code($response);
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true, 512, JSON_UNESCAPED_UNICODE);

            optimized_error_log('API 响应状态码: ' . esc_html($response_code));
            optimized_error_log('API 响应内容摘要: ' . esc_html(substr(json_encode($data, JSON_UNESCAPED_UNICODE), 0, 500)));

            // 处理响应
            if ($response_code === 401) {
                optimized_error_log('API 身份验证失败: ' . (isset($data['message']) ? esc_html($data['message']) : '未知错误'));
            } elseif ($response_code === 400) {
                optimized_error_log('API 请求体解析失败: ' . (isset($data['message']) ? esc_html($data['message']) : '未知错误'));
            } else {
                $reply_content = '';
                if (isset($data['choices'][0]['message']['content'])) {
                    $reply_content = $data['choices'][0]['message']['content'];
                } elseif (isset($data['choices'][0]['text'])) {
                    $reply_content = $data['choices'][0]['text'];
                }

                if (!empty($reply_content)) {
                    // 增加对评论内容的进一步验证
                    $reply_content = trim($reply_content);
                    if (empty($reply_content)) {
                        optimized_error_log('回复内容为空，跳过插入');
                        return;
                    }

                    // 确保评论内容长度在允许范围内
                    $max_length = 65535; // MySQL TEXT 字段最大长度
                    if (strlen($reply_content) > $max_length) {
                        $reply_content = substr($reply_content, 0, $max_length);
                        optimized_error_log('回复内容过长，已截断');
                    }

                    // 安全处理回复内容
                    $reply_content = esc_textarea($reply_content);
                    $reply_content = wp_kses_post($reply_content);

                    // 直接回复到评论区
                    $user = get_user_by('ID', $bot_user_id);
                    if ($user) {
                        $new_comment = array(
                            'comment_post_ID' => $commentdata['comment_post_ID'],
                            'comment_author' => $user->display_name,
                            'comment_author_email' => $user->user_email,
                            'comment_author_url' => $user->user_url,
                            'comment_content' => $reply_content,
                            'comment_type' => '',
                            'comment_parent' => $comment_ID,
                            'user_id' => $bot_user_id,
                            'comment_author_IP' => '',
                            'comment_agent' => '',
                            'comment_date' => current_time('mysql'),
                            'comment_approved' => 1,
                        );

                        $new_comment_id = wp_new_comment($new_comment);
                        if ($new_comment_id) {
                            optimized_error_log('评论回复已发布到评论区，评论 ID: ' . $new_comment_id);
                        } else {
                            optimized_error_log('评论回复发布失败');
                        }

                        // 检查并创建 locks 目录
                        $lock_dir = WP_CONTENT_DIR . '/locks';
                        if (!file_exists($lock_dir)) {
                            mkdir($lock_dir, 0755, true);
                        }
                        $lock_file = $lock_dir . '/deepseek_comment_reply.lock';
                        $fp = fopen($lock_file, 'w');
                        if ($fp && flock($fp, LOCK_EX)) { // 获得独占锁
                            // 检查并创建 replies 目录
                            $reply_dir = WP_CONTENT_DIR . '/replies';
                            if (!file_exists($reply_dir)) {
                                mkdir($reply_dir, 0755, true);
                            }
                            $reply_file = $reply_dir . '/deepseek_comment_reply_' . $comment_ID . '.txt';
                            file_put_contents($reply_file, $reply_content);
                            optimized_error_log('评论回复已保存到文件: ' . $reply_file);
                            flock($fp, LOCK_UN); // 释放锁
                        } else {
                            optimized_error_log('无法获得锁文件: ' . $lock_file);
                        }
                        if ($fp) {
                            fclose($fp);
                        }
                    } else {
                        optimized_error_log('未找到指定 ID 的用户: ' . $bot_user_id);
                    }
                } else {
                    optimized_error_log('API 响应未包含预期的回复: ' . esc_html($body));
                }
            }
        }
    }
}
add_action('comment_post', 'deepseek_comment_reply_on_new_comment', 10, 3);


