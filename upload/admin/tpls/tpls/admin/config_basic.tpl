<form method="post" action="?c=config&a=basic">
	  <b>ϵͳ״̬����</b><br />
	
		ϵͳ״̬��
	  �رջ���ϵͳ<br />
        <{html_radios name="config[sysopen]" options=$option_toggle checked=$config.yl_sysopen separator="<br />"}>

		DEBUG ģʽ����ϵͳ��
		  �����γ��򱨴���Ϣ��ϵͳ�����쳣ʱ�򿪴�ģʽ����������Ϣ�ύ�����򿪷�Ա���Ա㾡��õ����
		<br />
			<{html_radios name="config[debug]" options=$option_toggle checked=$config.yl_debug separator="<br />"}>

	ϵͳ��������
		ϵͳ���⣺
		<input name="config[sysname]" value="<{$config.yl_sysname}>" /><br />
		ϵͳ��ַ��(ע�ⲻҪ����ַ���� / )
		<input  name="config[sysurl]" value="<{$config.yl_sysurl}>" /><br />
		��ϵ����URL��(������ҳβ)
		<input  name="config[ceoconnect]" value="<{$config.yl_ceoconnect}>" /><br />
		����Ա���䣺
		<input  name="config[ceoemail]" value="<{$config.yl_ceoemail}>" /><br />
	
		ICP ������Ϣ��
		<input  name="config[icp]" value="<{$config.yl_icp}>" /><br />
	
		ICP ������Ϣ���ӵ�ַ��
		<input  name="config[icpurl]" value="<{$config.yl_icpurl}>" /><br />
	
	  վ��ͳ�ƴ���:
	  
	    <textarea id="config[ipstat]" rows="5" cols="40" name="config[ipstat]"><script type="text/javascript" src="http://js.tongji.linezing.com/1178691/tongji.js"></script><noscript><a href="http://www.linezing.com"><img src="http://img.tongji.linezing.com/1178691/tongji.gif"/></a></noscript></textarea>	  
  


<br/>
	<a href="#top">���Ĺ�������</a>
		�����Ż�:<br/>����<b>15����</b>����<b>1000��</b>���ϴ򿪴�ѡ��
		
			<{html_radios name="config[lp]" options=$option_toggle checked=$config.yl_lp separator="<br />"}>
	
		GZIP ѹ�����:
		ѡ���ǽ�����ϵͳͨ�� gzip ���ҳ��,���Ժ����ԵĽ��ʹ�������,��ֻ���ڿͻ���֧�ֵ�����²ſ�ʹ��,����Ӵ������ϵͳ����
		
			<{html_radios name="config[obstart]" options=$option_toggle checked=$config.yl_obstart separator="<br />"}>
	
		������ʱ��У�� (��)<br/>�˹�������У������������ϵͳʱ�����ô��������<br/>
		��ȷ��ϵͳĬ��ʱ��������ȷ��ϵͳ��ʾʱ�����д�����ʹ�ô˹���У��
		<input type="text"  name="config[cvtime]" value="<{$config.yl_cvtime}>" /><br />
	
		Ĭ��ʱ������<br/>ϵͳ����ʱ����Ĭ�����ã��οͺ���ע���û���ʱ�䰴��������ʾ
			<select name="config[timedf]">
                <{html_options  options=$timezone selected=$config.yl_timedf }>
			</select>		
	
		ϵͳĬ��ʱ����ʾ��ʽ<br/>��ʽ��:yyyy-mm-dd��yy-m-d<br/>yyyy����4λ����ݣ�yy����2λ�����<br/>mm������ǰ����01-12��m����ûǰ����1-12<br/>dd������ǰ����01-31��d����ûǰ����1-31
		
			<input  name="config[datefm]" value="<{$config.yl_datefm}>" /><br />
			<{html_radios name="time_f" options=$option_time_f checked=$time_f separator="<br />"}>
	
		�Ƿ�ʹ���Զ���ת(���������ΪNT.����رմ�ѡ��������޷���¼.�뿪��)
		
			<{html_radios name="config[ifjump]" options=$option_toggle checked=$config.yl_ifjump separator="<br />"}>
	

		ˢ��Ԥ��ʱ��(�������ˢ�±���Ϊ����ˢ��,��Ϊ0��������)��
		<input  name="config[refreshtime]" value="<{$config.yl_refreshtime}>" /><br />
	
		COOKIE��ЧĿ¼ ,ʹһ���ռ���ö��ϵͳ,���ܷ���! <font color="red">ע������������Ĵ������ã����򽫿��ܵ����޷���¼ϵͳ���쳣����</font>
		<input  name="config[ckpath]" value="<{$config.yl_ckpath}>" /><br />
	
		COOKIE��Ч���� ������ܻ�����ʹ�� http://114la.com��������ϵͳ��ʱ����������Ϊ 114la.com ������<br/><font color="red">ע������������Ĵ������ã����򽫿��ܵ����޷���¼ϵͳ���쳣����</font>
		<input  name="config[ckdomain]" value="<{$config.yl_ckdomain}>" /><br />
	
		�Ƿ���ҳ����ʾ��������ʱ�䣺
		
			<{html_radios name="config[footertime]" options=$option_toggle checked=$config.yl_footertime separator="<br />"}>
	
<br/>


  SEO��������

		Meta �ؼ���<br/>
	  Ϊ����ҳ������ Meta �ؼ���,����������������ҵ�������ҳ.
		<input  name="config[metakeyword]" value="<{$config.yl_metakeyword}>" /><br />
	
		Meta ����<br/>
		Ϊ����ҳ������ Meta ����,�Ա��ܹ���������������ȷ������������ҳ.
		<input  name="config[metadescrip]" value="<{$config.yl_metadescrip}>" /><br />
	
	  ����ҳ�ļ�����(����ļ���֮����|����)
	  <label>
	    <input type="text"  id="config[mulindex]" name="config[mulindex]" value="<{$config.yl_mulindex}>" /><br />
	  </label>
    
<br/>


	
	  <a href="#top">ͳ������</a>
	
		�Ƿ�������IPͳ��:
		
			<{html_radios name="config[ipstates]" options=$option_toggle checked=$config.yl_ipstates separator="<br />"}>
	
	  �Ƿ�������ISP ͳ��:(�ڿ���IPͳ�Ƶ��������Ч)
	  <label>
	    <{html_radios name="config[isp]" options=$option_toggle checked=$config.yl_isp separator="<br />"}>
	  </label>
    


	
	  <a href="#top">��������</a>
	
		�Ƿ�memcache ����
		
			<{html_radios name="config[enmemcache]" options=$option_toggle checked=$config.yl_enmemcache separator="<br />"}>
	
	  memcache server��ַ:(����:127.0.0.1)
	  <label>
	  <input type="text"  id="config[memcacheserver]" name="config[memcacheserver]" value="<{$config.yl_memcacheserver}>" /><br />
	  </label>
    
	  memcache server�˿�:(Ĭ��:11211)
	  <label>
	    <input type="text" name="config[memcacheport]" value="<{$config.yl_memcacheport}>" /><br />
	  </label>
    
<br/>
<a href="#top">��վ��¼��������</a>  <a id="set4" name="set4"/>

  �Ƿ��������ʼ�����:
  <label>
    <{html_radios  name="config[sendemail]" options=$option_toggle checked=$config.yl_sendemail separator="<br />"}>
  </label>

  �����ʼ����ͷ�ʽ:
  <label>
    <{html_radios name="config[sendemailtype]" options=$option_sendmailtype checked=$config.yl_sendemailtype separator="<br />"}>

  �����˵�ַ:
  <label>
    <input name="config[formemail]" value="<{$config.yl_formemail}>" /><br />
  </label>

  SMTP ��������ַ:
  <label>
    <input type="text"  name="config[smtpserver]" value="<{$config.yl_smtpserver}>" /><br />
  </label>

  SMTP �������˿�:(Ĭ��:25)
  <label>
    <input type="text" name="config[smtpport]" value="<{$config.yl_smtpport}>" /><br />
  </label>

  SMTP �������Ƿ���Ҫ��ȫ����(SSL):(һ�㲻��Ҫssl����,GMAIL ��Ҫ)(PHP��Ҫ����openssl)
  <label>
    <{html_radios name="config[smtpssl]" options=$option_toggle checked=$config.yl_smtpssl separator="<br />"}>

  SMTP �������Ƿ���Ҫ�û���֤:
  <label>
    <{html_radios name="config[smtpauth]" options=$option_toggle checked=$config.yl_smtpauth separator="<br />"}>
  </label>

  SMTP ��������֤�û���:(��ͨ�ʼ���֤����Ҫ��@����)
    <input type="text"  name="config[smtpid]"  value="<{$config.yl_smtpid}>"  /><br />

  SMTP ��������֤����:
  <label>
    <input type="password"  id="config[smtppass]" name="config[smtppass]" value="<{$config.yl_smtppass}>" /><br />
  </label>

  �Ƿ����汾������ʾ:
  <label>
    <{html_radios name="config[display_update_info]" options=$option_toggle checked=$config.yl_display_update_info separator="<br />"}>
  </label>

<input type="submit" value="�� ��"/>
</form>
