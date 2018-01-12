#pragma once

#define FTP_ENCRYPTION_NONE		0
#define FTP_ENCRYPTION_SSL		1

class CNetFtp
{
public:
	// iEncrytion: 0 Normal
	//             1 Require explicit FTP over TLS 
	CNetFtp(CString strUserName, CString strPassword, int iEncryption);
	~CNetFtp(void);

	bool UpLoadFile(CString strLocal, CString strRemote);

protected:
	CString m_strUserName;
	CString m_strPassword;
	int m_iEncryption;
};
