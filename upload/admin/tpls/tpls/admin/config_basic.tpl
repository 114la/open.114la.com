<form method="post" action="?c=config&a=basic">
	  <b>系统状态设置</b><br />
	
		系统状态：
	  关闭或开启系统<br />
        <{html_radios name="config[sysopen]" options=$option_toggle checked=$config.yl_sysopen separator="<br />"}>

		DEBUG 模式运行系统：
		  不屏蔽程序报错信息，系统出现异常时打开此模式，将错误信息提交给程序开发员，以便尽快得到解决
		<br />
			<{html_radios name="config[debug]" options=$option_toggle checked=$config.yl_debug separator="<br />"}>

	系统资料设置
		系统标题：
		<input name="config[sysname]" value="<{$config.yl_sysname}>" /><br />
		系统地址：(注意不要在网址最后加 / )
		<input  name="config[sysurl]" value="<{$config.yl_sysurl}>" /><br />
		联系我们URL：(出现在页尾)
		<input  name="config[ceoconnect]" value="<{$config.yl_ceoconnect}>" /><br />
		管理员信箱：
		<input  name="config[ceoemail]" value="<{$config.yl_ceoemail}>" /><br />
	
		ICP 备案信息：
		<input  name="config[icp]" value="<{$config.yl_icp}>" /><br />
	
		ICP 备案信息链接地址：
		<input  name="config[icpurl]" value="<{$config.yl_icpurl}>" /><br />
	
	  站长统计代码:
	  
	    <textarea id="config[ipstat]" rows="5" cols="40" name="config[ipstat]"><script type="text/javascript" src="http://js.tongji.linezing.com/1178691/tongji.js"></script><noscript><a href="http://www.linezing.com"><img src="http://img.tongji.linezing.com/1178691/tongji.gif"/></a></noscript></textarea>	  
  


<br/>
	<a href="#top">核心功能设置</a>
		进程优化:<br/>建议<b>15分钟</b>在线<b>1000人</b>以上打开此选项
		
			<{html_radios name="config[lp]" options=$option_toggle checked=$config.yl_lp separator="<br />"}>
	
		GZIP 压缩输出:
		选择是将允许系统通过 gzip 输出页面,可以很明显的降低带宽需求,但只有在客户端支持的情况下才可使用,并会加大服务器系统开销
		
			<{html_radios name="config[obstart]" options=$option_toggle checked=$config.yl_obstart separator="<br />"}>
	
		服务器时间校正 (分)<br/>此功能用于校正服务器操作系统时间设置错误的问题<br/>
		当确认系统默认时区设置正确后，系统显示时间仍有错误，请使用此功能校正
		<input type="text"  name="config[cvtime]" value="<{$config.yl_cvtime}>" /><br />
	
		默认时区设置<br/>系统所在时区的默认设置，游客和新注册用户的时间按此设置显示
			<select name="config[timedf]">
                <{html_options  options=$timezone selected=$config.yl_timedf }>
			</select>		
	
		系统默认时间显示格式<br/>格式如:yyyy-mm-dd，yy-m-d<br/>yyyy代表4位数年份，yy代表2位数年份<br/>mm代表有前导零01-12，m代表没前导零1-12<br/>dd代表有前导零01-31，d代表没前导零1-31
		
			<input  name="config[datefm]" value="<{$config.yl_datefm}>" /><br />
			<{html_radios name="time_f" options=$option_time_f checked=$time_f separator="<br />"}>
	
		是否使用自动跳转(如果服务器为NT.如果关闭此选项而出现无法登录.请开启)
		
			<{html_radios name="config[ifjump]" options=$option_toggle checked=$config.yl_ifjump separator="<br />"}>
	

		刷新预防时间(多少秒间刷新被视为恶意刷新,设为0则不做限制)：
		<input  name="config[refreshtime]" value="<{$config.yl_refreshtime}>" /><br />
	
		COOKIE有效目录 ,使一个空间放置多个系统,都能访问! <font color="red">注：请勿随意更改此项设置，否则将可能导致无法登录系统等异常现象</font>
		<input  name="config[ckpath]" value="<{$config.yl_ckpath}>" /><br />
	
		COOKIE有效域名 比如可能会有人使用 http://114la.com访问您的系统这时您可以设置为 114la.com 或留空<br/><font color="red">注：请勿随意更改此项设置，否则将可能导致无法登录系统等异常现象</font>
		<input  name="config[ckdomain]" value="<{$config.yl_ckdomain}>" /><br />
	
		是否在页脚显示程序运行时间：
		
			<{html_radios name="config[footertime]" options=$option_toggle checked=$config.yl_footertime separator="<br />"}>
	
<br/>


  SEO基本设置

		Meta 关键词<br/>
	  为所有页面输入 Meta 关键词,让搜索引擎更容易找到您的网页.
		<input  name="config[metakeyword]" value="<{$config.yl_metakeyword}>" /><br />
	
		Meta 描述<br/>
		为所有页面输入 Meta 描述,以便能够在搜索引擎中正确搜索到您的网页.
		<input  name="config[metadescrip]" value="<{$config.yl_metadescrip}>" /><br />
	
	  多首页文件设置(多个文件名之间用|隔开)
	  <label>
	    <input type="text"  id="config[mulindex]" name="config[mulindex]" value="<{$config.yl_mulindex}>" /><br />
	  </label>
    
<br/>


	
	  <a href="#top">统计设置</a>
	
		是否开启到访IP统计:
		
			<{html_radios name="config[ipstates]" options=$option_toggle checked=$config.yl_ipstates separator="<br />"}>
	
	  是否开启到访ISP 统计:(在开启IP统计的情况下有效)
	  <label>
	    <{html_radios name="config[isp]" options=$option_toggle checked=$config.yl_isp separator="<br />"}>
	  </label>
    


	
	  <a href="#top">缓存设置</a>
	
		是否memcache 缓存
		
			<{html_radios name="config[enmemcache]" options=$option_toggle checked=$config.yl_enmemcache separator="<br />"}>
	
	  memcache server地址:(本地:127.0.0.1)
	  <label>
	  <input type="text"  id="config[memcacheserver]" name="config[memcacheserver]" value="<{$config.yl_memcacheserver}>" /><br />
	  </label>
    
	  memcache server端口:(默认:11211)
	  <label>
	    <input type="text" name="config[memcacheport]" value="<{$config.yl_memcacheport}>" /><br />
	  </label>
    
<br/>
<a href="#top">网站收录邮箱配置</a>  <a id="set4" name="set4"/>

  是否开启电子邮件发送:
  <label>
    <{html_radios  name="config[sendemail]" options=$option_toggle checked=$config.yl_sendemail separator="<br />"}>
  </label>

  电子邮件发送方式:
  <label>
    <{html_radios name="config[sendemailtype]" options=$option_sendmailtype checked=$config.yl_sendemailtype separator="<br />"}>

  发信人地址:
  <label>
    <input name="config[formemail]" value="<{$config.yl_formemail}>" /><br />
  </label>

  SMTP 服务器地址:
  <label>
    <input type="text"  name="config[smtpserver]" value="<{$config.yl_smtpserver}>" /><br />
  </label>

  SMTP 服务器端口:(默认:25)
  <label>
    <input type="text" name="config[smtpport]" value="<{$config.yl_smtpport}>" /><br />
  </label>

  SMTP 服务器是否需要安全连接(SSL):(一般不需要ssl连接,GMAIL 需要)(PHP需要启用openssl)
  <label>
    <{html_radios name="config[smtpssl]" options=$option_toggle checked=$config.yl_smtpssl separator="<br />"}>

  SMTP 服务器是否需要用户验证:
  <label>
    <{html_radios name="config[smtpauth]" options=$option_toggle checked=$config.yl_smtpauth separator="<br />"}>
  </label>

  SMTP 服务器验证用户名:(普通邮件认证不需要加@域名)
    <input type="text"  name="config[smtpid]"  value="<{$config.yl_smtpid}>"  /><br />

  SMTP 服务器验证密码:
  <label>
    <input type="password"  id="config[smtppass]" name="config[smtppass]" value="<{$config.yl_smtppass}>" /><br />
  </label>

  是否开启版本升级提示:
  <label>
    <{html_radios name="config[display_update_info]" options=$option_toggle checked=$config.yl_display_update_info separator="<br />"}>
  </label>

<input type="submit" value="提 交"/>
</form>
