#include "StdAfx.h"
#include "DownloadFile.h"

const CString c_str_all = _T("_all");

CDownloadFile::CDownloadFile(void)
{
}

CDownloadFile::~CDownloadFile(void)
{
}

bool CDownloadFile::Modify(CString strPathName)
{
	if (!GetFileName(strPathName))		return false;
	if (!GetFileDate(strPathName))		return false;

	if (!GetVersion())					return false;
	if (!GetHardwareType())				return false;

	if (m_strHardwareType == _T("ar1688"))
	{
		if (!ModifyApi(true, false))	return false;
		if (!ModifyApi(true, true))		return false;
		if (!ModifyApi(false, false))	return false;
		if (!ModifyApi(false, true))	return false;
	}
	else if (m_strHardwareType == _T("pa1688"))
	{
		if (!ModifyApi(false, false))	return false;
		if (!ModifyApi(false, true))	return false;
	}
	else if (IsAR1688VoIPModule(m_strHardwareType) || m_strHardwareType == _T("ar168r") || m_strHardwareType == _T("ar168ds")
		|| IsAR1688IpPhone(m_strHardwareType))
	{
		if (!ModifyBin(_T("ar1688"), false))		return false;
		if (!ModifyBin(_T("ar1688"), true))			return false;
	}
	else if (IsPA1688IpPhone(m_strHardwareType) || m_strHardwareType == _T("pa168p"))
	{
		if (!ModifyBin(_T("pa1688"), false))		return false;
		if (!ModifyBin(_T("pa1688"), true))			return false;
	}
	else
	{
		AfxMessageBox(_T("Unknown hardware type"));
		return false;
	}

	return true;
}

bool CDownloadFile::IsAR1688VoIPModule(CString strHardwareType)
{
	if (strHardwareType == _T("ar168m") || strHardwareType == _T("ar168ms") || strHardwareType == _T("ar168mt"))
		return true;
	return false;
}

bool CDownloadFile::IsAR1688IpPhone(CString strHardwareType)
{
	if (strHardwareType == _T("ywh201") || strHardwareType == _T("gf302") || strHardwareType == _T("ar168p") || strHardwareType == _T("ar168k"))
		return true;
	return false;
}

bool CDownloadFile::IsPA1688IpPhone(CString strHardwareType)
{
	if (strHardwareType == _T("5111phone") || strHardwareType == _T("pa168s") || strHardwareType == _T("ywh10") || strHardwareType == _T("ywh200"))
		return true;
	return false;
}

CString CDownloadFile::HardwareDisplayIpPhone(CString strHardwareType, bool bChinese)
{
	CString str;

	str = strHardwareType;
	str.MakeUpper();
	if (bChinese)
	{
		str += _T("网络电话");
	}
	else
	{
		str += _T(" IP phone");
	}
	return str;
}

CString CDownloadFile::HardwareDisplayVoIPModule(CString strHardwareType, bool bChinese)
{
	CString str;

	str = strHardwareType;
	str.MakeUpper();
	if (bChinese)
	{
		str += _T("网络语音模块");
	}
	else
	{
		str += _T(" VoIP module");
	}
	return str;
}

bool CDownloadFile::ModifyBin(CString strChip, bool bChinese)
{
	CString strInsert;
	CString strFileName;

	CString strHardwareDisplay;
	CString strFileDisplay;

	if (m_strProtocol == _T("sip"))
	{
		strFileDisplay = _T("SIP");
	}
	else if (m_strProtocol == _T("iax2"))
	{
		strFileDisplay = _T("IAX2");
	}
	else if (m_strProtocol == _T("h323"))
	{
		strFileDisplay = _T("H323");
	}
	else if (m_strProtocol == _T("none"))
	{
		if (bChinese)
		{
			strFileDisplay = _T("安全模式");
		}
		else
		{
			strFileDisplay = _T("Safe Mode");
		}
	}

	if (bChinese)
	{
		strFileName.Format(_T("%s\\software\\sw%scn.html"), strChip, m_strMainVersion);

		if (IsAR1688VoIPModule(m_strHardwareType))
		{
			strHardwareDisplay = HardwareDisplayVoIPModule(m_strHardwareType, true);
		}
		else if (m_strHardwareType == _T("ar168r"))
		{
			strHardwareDisplay = _T("AR168R RoIP模块");
		}
		else if (m_strHardwareType == _T("ar168ds"))
		{
			strHardwareDisplay = _T("AR168DS编程器");
		}
		else if (IsAR1688IpPhone(m_strHardwareType) || IsPA1688IpPhone(m_strHardwareType))
		{
			strHardwareDisplay = HardwareDisplayIpPhone(m_strHardwareType, true);
		}
		else if (m_strHardwareType == _T("pa168p"))
		{
			strHardwareDisplay = _T("PA168P单口网关");
		}

		if (m_strLanguage == _T("us"))
		{
			strFileDisplay += _T("英文");
		}
		else if (m_strLanguage == _T("cn"))
		{
			strFileDisplay += _T("中文");
		}
		else if (m_strLanguage == _T("es"))
		{
			strFileDisplay += _T("西班牙文");
		}
		else if (m_strLanguage == _T("fr"))
		{
			strFileDisplay += _T("法文");
		}

		if (m_strOem != _T(""))
		{
			strFileDisplay += m_strOem;
		}

		if (m_bProgrammerFile)
		{
			strFileDisplay += _T("烧录文件");
		}

		//<br />2013年3月8日AR168R RoIP模块 0.61.018 <a href="061/ar168r_sip_us_remota_061018.zip">SIP英文OEM_REMOTA</a>
		strInsert.Format(_T("<br />%s%s %s <a href=\"%s/%s\">%s</a>"), 
			m_strChineseDate, strHardwareDisplay, m_strVersion, m_strMainVersion, m_strFileName, strFileDisplay);
	}
	else
	{
		strFileName.Format(_T("%s\\software\\sw%s.html"), strChip, m_strMainVersion);

		if (IsAR1688VoIPModule(m_strHardwareType))
		{
			strHardwareDisplay = HardwareDisplayVoIPModule(m_strHardwareType, false);
		}
		else if (m_strHardwareType == _T("ar168r"))
		{
			strHardwareDisplay = _T("AR168R RoIP module");
		}
		else if (m_strHardwareType == _T("ar168ds"))
		{
			strHardwareDisplay = _T("AR168DS Programmer");
		}
		else if (IsAR1688IpPhone(m_strHardwareType) || IsPA1688IpPhone(m_strHardwareType))
		{
			strHardwareDisplay = HardwareDisplayIpPhone(m_strHardwareType, false);
		}
		else if (m_strHardwareType == _T("pa168p"))
		{
			strHardwareDisplay = _T("PA168P 1-port FXS gateway");
		}

		strFileDisplay += _T(" ");
		if (m_strLanguage == _T("us"))
		{
			strFileDisplay += _T("English");
		}
		else if (m_strLanguage == _T("cn"))
		{
			strFileDisplay += _T("Chinese");
		}
		else if (m_strLanguage == _T("es"))
		{
			strFileDisplay += _T("Spanish");
		}
		else if (m_strLanguage == _T("fr"))
		{
			strFileDisplay += _T("French");
		}

		if (m_strOem != _T(""))
		{
			strFileDisplay += _T(" ") + m_strOem;
		}

		if (m_bProgrammerFile)
		{
			strFileDisplay += _T(" Programmer File");
		}

		//<br />Mar 8, 2013 AR168R RoIP module 0.61.018 <a href="061/ar168r_sip_us_remota_061018.zip">SIP English OEM_REMOTA</a>
		strInsert.Format(_T("<br />%s %s %s <a href=\"%s/%s\">%s</a>"), 
			m_strDate, strHardwareDisplay, m_strVersion, m_strMainVersion, m_strFileName, strFileDisplay);
	}

	return ModifyFile(strFileName, strInsert);
}

bool CDownloadFile::ModifyApi(bool bSnapshot, bool bChinese)
{
	CString strInsert;
	CString strFileName;

	if (bChinese)
	{
		if (bSnapshot)
		{
			strFileName = _T("ar1688\\software\\snapshotcn.html");
		}
		else
		{
			strFileName.Format(_T("%s\\software\\sw%scn.html"), m_strHardwareType, m_strMainVersion);
		}
		strInsert.Format(_T("<br />%s更新的<a href=\"snapshot/%s\">%s</a>版本API"), m_strChineseDate, m_strFileName, m_strVersion);
	}
	else
	{
		if (bSnapshot)
		{
			strFileName = _T("ar1688\\software\\snapshot.html");
		}
		else
		{
			strFileName.Format(_T("%s\\software\\sw%s.html"), m_strHardwareType, m_strMainVersion);
		}
		strInsert.Format(_T("<br />API <a href=\"snapshot/%s\">%s</a> updated on %s"), m_strFileName, m_strVersion, m_strDate);
	}
	if (bSnapshot)	strInsert += _T(".");
	return ModifyFile(strFileName, strInsert);
}

bool CDownloadFile::ModifyFile(CString strFileName, CString strInsert)
{
	return InsertFile(strFileName, strInsert, _T("mailto:support@palmmicro.com"));

/*	CStringList list;
	POSITION pos, old;
	CString str;

	if (!ReadToStringList(strFileName, list))	return false;

	// process
	for (pos = list.GetTailPosition(); pos != NULL;)
	{
		old = pos;
		str = list.GetPrev(pos);
		if (str.Find(_T("mailto:support@palmmicro.com")) != -1)
		{
			list.InsertAfter(old, strInsert);
			break;
		}
	}

	return WriteFromStringList(strFileName, list);
*/
}

/*
bool CDownloadFile::GetFileName(CString strPathName)
{
	int iPos = strPathName.ReverseFind(_T('\\'));
	if (iPos == -1)	return false;

	m_strFileName = strPathName.Right(strPathName.GetLength() - iPos - 1);

	OutputDebugString(m_strFileName + _T("\n"));
	return true;
}

bool CDownloadFile::GetFileDate(CString strPathName)
{
	CFileStatus status;

	if (!CFile::GetStatus(strPathName, status))		return false;

	Generate(status.m_ctime.GetYear(), status.m_ctime.GetMonth(), status.m_ctime.GetDay());

	OutputDebugString(m_strDate + _T("\n"));
	return true;
}
*/

// ar168p_sip_us_063034_all.zip
// ar168p_sip_us_063034.zip
bool CDownloadFile::GetVersion()
{
	int i, iLen;
	CString strVersion;

	int iDotPos = m_strFileName.Find(_T('.'));
	if (iDotPos == -1)	return false;
	if (iDotPos < VERSION_LEN)	return false;

	iLen = c_str_all.GetLength();
	if (m_strFileName.Mid(iDotPos - iLen, iLen) == c_str_all)
	{
		strVersion = m_strFileName.Mid(iDotPos - VERSION_LEN - iLen, VERSION_LEN);
		m_bProgrammerFile = true;
	}
	else
	{
		strVersion = m_strFileName.Mid(iDotPos - VERSION_LEN, VERSION_LEN);
		m_bProgrammerFile = false;
	}
//	OutputDebugString(strVersion + _T("\n"));

	for (i = 0; i < VERSION_LEN; i ++)
	{
		m_piVersion[i] = strVersion.GetAt(i) - _T('0');
		if (m_piVersion[i] < 0 || m_piVersion[i] > 9)		return false;
	}

	m_strVersion.Format(_T("%d.%d%d.%d%d%d"), m_piVersion[0], m_piVersion[1], m_piVersion[2], m_piVersion[3], m_piVersion[4], m_piVersion[5]);
	m_strMainVersion.Format(_T("%d%d%d"), m_piVersion[0], m_piVersion[1], m_piVersion[2]);

	OutputDebugString(m_strVersion + _T("\n"));
	return true;
}

// ar168p_sip_us_063034_all.zip
// ar168p_sip_us_mac_063034.zip
bool CDownloadFile::GetHardwareType()
{
	CString str;

	int iDotPos = m_strFileName.Find(_T('_'));
	if (iDotPos == -1)	return false;

	m_strHardwareType = m_strFileName.Left(iDotPos);
	m_strHardwareType.MakeLower();
	OutputDebugString(m_strHardwareType + _T("\n"));

	m_strProtocol = _T("");
	m_strLanguage = _T("");
	m_strOem = _T("");

	str = m_strFileName.Right(m_strFileName.GetLength() - iDotPos - 1);
	iDotPos = str.Find(_T('_'));
	if (iDotPos == -1)	return true;

	m_strProtocol = str.Left(iDotPos);
	m_strProtocol.MakeLower();
	OutputDebugString(m_strProtocol + _T("\n"));

	str = str.Right(str.GetLength() - iDotPos - 1);
	iDotPos = str.Find(_T('_'));
	if (iDotPos == -1)	return true;

	m_strLanguage = str.Left(iDotPos);
	m_strLanguage.MakeLower();
	OutputDebugString(m_strLanguage + _T("\n"));

	str = str.Right(str.GetLength() - iDotPos - 1);
	iDotPos = str.Find(_T('_'));
	if (iDotPos == -1)	return true;

	if (m_bProgrammerFile)
	{
		if (str.Mid(iDotPos, c_str_all.GetLength()) == c_str_all)	return true;
	}

	str = str.Left(iDotPos);
	str.MakeUpper();
	m_strOem = _T("OEM_") + str;
	OutputDebugString(m_strOem + _T("\n"));

	return true;
}

