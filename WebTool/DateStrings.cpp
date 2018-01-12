#include "StdAfx.h"
#include "DateStrings.h"

const TCHAR c_cMonth[][12] = {_T("Jan"), _T("Feb"), _T("March"), _T("Apr"), _T("May"), _T("June"), _T("July"), _T("Aug"), _T("Sep"), _T("Oct"), _T("Nov"), _T("Dec")};

CDateStrings::CDateStrings(void)
{
}

CDateStrings::~CDateStrings(void)
{
}

void CDateStrings::Generate(int iYear, int iMon, int iDay)
{
	m_strDate.Format(_T("%s %d, %d"), c_cMonth[iMon-1], iDay, iYear);
	m_strChineseDate.Format(_T("%d年%d月%d日"), iYear, iMon, iDay);
	m_strDateNoYear.Format(_T("%s %d"), c_cMonth[iMon-1], iDay);
	m_strChineseDateNoYear.Format(_T("%d月%d日"), iMon, iDay);

	m_iYear = iYear;
	m_iMon = iMon;
	m_iDay = iDay;
}

