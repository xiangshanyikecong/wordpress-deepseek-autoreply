DeepSeek 评论系统插件管理员后台配置文档
官方链接：
https://hmcsz.top/index.php/2025/03/06/wordpress%e4%b8%8b%e7%9a%84deepseek-%e8%af%84%e8%ae%ba%e7%b3%bb%e7%bb%9f-%e6%8f%92%e4%bb%b6%e6%93%8d%e4%bd%9c%e6%96%87%e6%a1%a3/

1. 插件概述
DeepSeek 评论系统插件用于对接 DeepSeek API 实现自动回复访客评论的功能。
我们深度建议您使用欧派云（https://ppinfra.com/user/register?invited_by=F1E6HR）
作为api服务商，当然，若其它服务商提供的api可正常运行那也没问题。

2. 安装与激活
将插件文件上传到 WordPress 插件目录，然后在 WordPress 后台的“插件”页面中激活该插件。

3. 配置页面访问
在 WordPress 管理员后台，点击左侧菜单中的“设置”，找到“DeepSeek Comment Reply”并点击，即可进入插件的配置页面。

4. 配置项说明
4.1 DeepSeek API 设置
API Key：DeepSeek API 的访问密钥，用于身份验证。请从 DeepSeek 平台获取该密钥，并填写到此处。
API URL：DeepSeek API 的请求地址。请确保该地址的正确性，否则无法正常调用 API。
Prompt：自定义的提示词，用于引导 DeepSeek 生成回复内容。可以根据需要编写合适的提示信息。（例：你现在是某某某的站长，你需要友好的回复访客的评论，不要使用表情包）
Model ID：指定使用的 DeepSeek 模型 ID。不同的模型可能具有不同的性能和特点，请根据实际需求选择。
机器人用户 ID：用于标识自动回复评论的机器人用户。请输入该用户的 ID，以便系统识别和处理。
回复豁免者：输入要豁免自动回复的用户 ID，多个 ID 用英文逗号分隔。这些用户的评论将不会触发自动回复。
5. 配置步骤
打开插件配置页面。
在“DeepSeek API 设置”部分，依次填写上述配置项。
填写完成后，点击页面底部的“保存更改”按钮，保存配置信息。
6. 日志查看
插件会将相关的错误信息和操作日志记录到 wp-content/logs/deepseek_comment_system.log 文件中。如果在使用过程中遇到问题，可以查看该日志文件以获取更多详细信息。

7. 注意事项
请确保 API Key 和 API URL 的正确性，否则将无法正常调用 DeepSeek API。
由于插件处于 Beta 版本，可能存在一些不稳定因素，建议在测试环境中进行充分测试后再考虑在生产环境中使用。
日志文件会进行轮换，当文件大小超过 10MB 时，会自动备份并创建新的日志文件。


8.关于Bug以及后续更新

1.我们非常感谢您提供的bug和建议，若想要联系我们，可向我们发布邮件：ad001@hmcsz.top，当我们收到邮件时，我们会及时处理，当然，也希望您在邮件中留下您的联系方式（WeChat，QQ，X），并在附件中提交错误日志和截图（还有服务器系统，PHP版本等）若有更新建议，也可向我们发送邮件，感谢您的使用！

2.若您使用的api服务商不可用，您也可联系我们，我们会适时考虑适配

3.后续更新也会在此页面发布敬请留意


9.运行环境

扩展和配置
PHP 扩展：确保服务器上安装了以下 PHP 扩展：json、mbstring、curl 等，这些扩展对于处理 JSON 数据、多字节字符和进行 HTTP 请求是必需的。
PHP 配置：在 php.ini 文件中，需要适当调整以下配置项：
memory_limit：建议设置为至少 256M，以确保 PHP 脚本有足够的内存来执行。
max_execution_time：建议设置为 300 秒，以避免脚本在处理 API 请求时超时。
网络连接：服务器需要能够访问 DeepSeek API 的网络地址，因此需要确保服务器具有稳定的网络连接。
文件权限：确保 WordPress 网站目录和文件具有正确的读写权限，特别是插件需要创建日志文件和目录的情况下，需要保证相应的目录具有写入权限。
PHP 版本：需要 PHP 版本 5.6 及以上，不过建议使用 PHP 7.4 或者更高版本，以获得更好的性能和安全性。


DeepSeek Comment System Plugin Admin Configuration Documentation

1. Plugin Overview
The DeepSeek Comment System Plugin integrates with the DeepSeek API to enable automated replies to visitor comments. This plugin is in Beta version and may contain issues. It is not recommended for use in production environments. This plugin is permanently free!

We highly recommend using Oppai Cloud (https://ppinfra.com/user/register?invited_by=F1E6HR) as the API service provider. However, other providers are acceptable if their APIs function properly.

2. Installation & Activation
Upload the plugin files to your WordPress plugins directory, then activate the plugin via the “Plugins” page in the WordPress admin dashboard.

3. Accessing the Configuration Page
In the WordPress admin dashboard, navigate to Settings → DeepSeek Comment Reply to access the plugin’s configuration page.

4. Configuration Settings
4.1 DeepSeek API Settings
API Key: The authentication key for accessing the DeepSeek API. Obtain this key from the DeepSeek platform and enter it here.
API URL: The endpoint URL for DeepSeek API requests. Ensure accuracy to avoid API call failures.
Prompt: Custom instructions to guide DeepSeek’s reply generation (e.g., “You are the administrator of [Website Name]. Reply to visitor comments in a friendly tone, avoiding emojis”).
Model ID: Specify the DeepSeek model ID. Choose based on performance and requirements.
Bot User ID: The user ID assigned to the automated reply bot for system identification.
Exempt Users: Enter user IDs (separated by commas) whose comments will not trigger automated replies.
5. Configuration Steps
Open the plugin configuration page.
Fill in all fields under the DeepSeek API Settings section.
Click Save Changes to apply configurations.
6. Log Monitoring
Plugin logs (errors and operations) are stored at:
wp-content/logs/deepseek_comment_system.log
Check this file for troubleshooting.

7. Notes
Ensure API Key and API URL are correct to avoid API failures.
This Beta plugin may be unstable. Test thoroughly before production use.
Log files rotate automatically when exceeding 10MB.
8. Bug Reporting & Updates
Submit bugs/suggestions to: ad001@hmcsz.top. Include:
Contact details (WeChat, QQ, X)
Error logs, screenshots, server OS, PHP version, etc.
API compatibility issues: Contact us for potential adaptations.
Updates will be announced on this page.
9. System Requirements
Extensions & Configurations
PHP Extensions: json, mbstring, curl (required for JSON, multibyte strings, and HTTP requests).
PHP Settings (php.ini):
memory_limit: ≥256M
max_execution_time: ≥300 seconds
Network: Stable connection to DeepSeek API endpoints.
File Permissions: Ensure write access to WordPress directories (e.g., for log creation).
PHP Version: ≥5.6 (recommended: ≥7.4 for security/performance).

by 香山一棵葱 Team
