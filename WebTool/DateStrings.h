#pragma once

class CDateStrings
{
public:
	CDateStrings(void);
	~CDateStrings(void);

	void Generate(int iYear, int iMon, int iDay);

protected:
	CString m_strDate;
	CString m_strChineseDate;
	CString m_strDateNoYear;
	CString m_strChineseDateNoYear;

	int m_iYear;
	int m_iMon;
	int m_iDay;
};
