#include "StdAfx.h"
#include "NetFtp.h"

#using <System.dll>

using namespace System;
using namespace System::Net;
using namespace System::Net::Security;
using namespace System::Security::Cryptography::X509Certificates;
using namespace System::Threading;
using namespace System::IO;

public ref class FtpState
{
private:
   ManualResetEvent^ wait;
   FtpWebRequest^ request;
   String^ fileName;
   Exception^ operationException;
   String^ status;

public:
   FtpState()
   {
      wait = gcnew ManualResetEvent( false );
   }

   property ManualResetEvent^ OperationComplete 
   {
      ManualResetEvent^ get()
      {
         return wait;
      }

   }

   property FtpWebRequest^ Request 
   {
      FtpWebRequest^ get()
      {
         return request;
      }

      void set( FtpWebRequest^ value )
      {
         request = value;
      }

   }

   property String^ FileName 
   {
      String^ get()
      {
         return fileName;
      }

      void set( String^ value )
      {
         fileName = value;
      }

   }

   property Exception^ OperationException 
   {
      Exception^ get()
      {
         return operationException;
      }

      void set( Exception^ value )
      {
         operationException = value;
      }

   }

   property String^ StatusDescription 
   {
      String^ get()
      {
         return status;
      }

      void set( String^ value )
      {
         status = value;
      }

   }
};

public ref class AsynchronousFtpUpLoader
{
public:

   // Command line arguments are two strings:
   // 1. The url that is the name of the file being uploaded to the server.
   // 2. The name of the file on the local machine.
   //
   static bool UpLoadFile(Char * pcLocalFile, Char * pcRemoteFile, Char * pcUserName, Char * pcPassword, int iEncryption)
   {
      // Create a Uri instance with the specified URI string.
      // If the URI is not correctly formed, the Uri constructor
      // will throw an exception.
      ManualResetEvent^ waitObject;
//	  String^ uri = "ftp://ftp.musictree.org/changsha.jpg";
	  String^ uri = gcnew String(pcRemoteFile);
      Uri^ target = gcnew Uri(uri);

//	  String^ fileName = "C:\\Palmmicro web\\changsha.jpg";
	  String^ fileName = gcnew String(pcLocalFile);
      FtpState^ state = gcnew FtpState;
      FtpWebRequest ^ request = dynamic_cast<FtpWebRequest^>(WebRequest::Create( target ));
      request->Method = WebRequestMethods::Ftp::UploadFile;
	  if (iEncryption == FTP_ENCRYPTION_SSL)
	  {
		  request->EnableSsl = true; // Here you enabled request to use ssl instead of clear text
//		  ServicePointManager.ServerCertificateValidationCallback = gcnew RemoteCertificateValidationCallback(MyCertificateValidationCallback);
		  System::Net::ServicePointManager::ServerCertificateValidationCallback  = gcnew RemoteCertificateValidationCallback(MyCertificateValidationCallback);
	  }

/*	  OutputDebugString(pcLocalFile);
	  OutputDebugString(_T("\n"));
	  OutputDebugString(pcRemoteFile);
	  OutputDebugString(_T("\n"));
*/

      // This example uses anonymous logon.
      // The request is anonymous by default; the credential does not have to be specified. 
      // The example specifies the credential only to
      // control how actions are logged on the server.
//      request->Credentials = gcnew NetworkCredential( "musictree@musictree.org","musictreesupport" );
	  String^ username = gcnew String(pcUserName);
	  String^ password = gcnew String(pcPassword);
	  request->Credentials = gcnew NetworkCredential(username, password);

      // Store the request in the object that we pass into the
      // asynchronous operations.
      state->Request = request;
      state->FileName = fileName;

      // Get the event to wait on.
      waitObject = state->OperationComplete;

      // Asynchronously get the stream for the file contents.
      request->BeginGetRequestStream( gcnew AsyncCallback( EndGetStreamCallback ), state );

      // Block the current thread until all operations are complete.
      waitObject->WaitOne();

      // The operations either completed or threw an exception.
      if ( state->OperationException != nullptr )
      {
         throw state->OperationException;
		 return false;
      }
      else
      {
//         Console::WriteLine( "The operation completed - {0}", state->StatusDescription );
/*		  CString str;
		  str.Format(_T("The operation completed - %s\n"), state->StatusDescription);
		  OutputDebugString(str);
*/
      }
	  return true;
   }

private:
   static void EndGetStreamCallback( IAsyncResult^ ar )
   {
      FtpState^ state = dynamic_cast<FtpState^>(ar->AsyncState);
      Stream^ requestStream = nullptr;

      // End the asynchronous call to get the request stream.
      try
      {
         requestStream = state->Request->EndGetRequestStream( ar );

         // Copy the file contents to the request stream.
         const int bufferLength = 2048;
         array<Byte>^buffer = gcnew array<Byte>(bufferLength);
         int count = 0;
         int readBytes = 0;
         FileStream^ stream = File::OpenRead( state->FileName );
         do
         {
            readBytes = stream->Read( buffer, 0, bufferLength );
			if (readBytes != 0)
			{
				requestStream->Write( buffer, 0, readBytes );
				count += readBytes;
			}
			else
			{
				break;
			}
         } while (1);
         // IMPORTANT: Close the request stream before sending the request.
//		 requestStream->Flush();
         requestStream->Close();
		 stream->Close();

//         Console::WriteLine( "Writing {0} bytes to the stream.", count );
		 CString str;
		 str.Format(_T("Writing %d bytes to the stream.\n"), count);
		 OutputDebugString(str);

         // Asynchronously get the response to the upload request.
         state->Request->BeginGetResponse( gcnew AsyncCallback( EndGetResponseCallback ), state );
      }
      // Return exceptions to the main application thread.
      catch ( Exception^ e ) 
      {
//         Console::WriteLine( "Could not get the request stream." );
		 OutputDebugString(_T("Could not get the request stream\n."));
         state->OperationException = e;
         state->OperationComplete->Set();
         return;
      }
   }

   // The EndGetResponseCallback method  
   // completes a call to BeginGetResponse.
   static void EndGetResponseCallback( IAsyncResult^ ar )
   {
      FtpState^ state = dynamic_cast<FtpState^>(ar->AsyncState);
      FtpWebResponse ^ response = nullptr;
      try
      {
         response = dynamic_cast<FtpWebResponse^>(state->Request->EndGetResponse( ar ));
         response->Close();
         state->StatusDescription = response->StatusDescription;

         // Signal the main application thread that 
         // the operation is complete.
         state->OperationComplete->Set();
      }
      // Return exceptions to the main application thread.
      catch ( Exception^ e ) 
      {
//         Console::WriteLine( "Error getting response." );
		 OutputDebugString(_T("Error getting response.\n"));
         state->OperationException = e;
         state->OperationComplete->Set();
      }
   }

   static bool MyCertificateValidationCallback(Object^ sender, X509Certificate^ certificate, X509Chain^ chain, SslPolicyErrors sslPolicyErrors)
   {
	    CString str;

		str.Format(_T("Certification validation callback error: %d.\n"), sslPolicyErrors);
		OutputDebugString(str);
		return true;
   }
};

bool CNetFtp::UpLoadFile(CString strLocal, CString strRemote)
{
	return AsynchronousFtpUpLoader::UpLoadFile((Char *)strLocal.GetBuffer(), (Char *)strRemote.GetBuffer(), (Char *)m_strUserName.GetBuffer(), (Char *)m_strPassword.GetBuffer(), m_iEncryption);
}


CNetFtp::CNetFtp(CString strUserName, CString strPassword, int iEncryption)
{
	m_strUserName = strUserName;
	m_strPassword = strPassword;
	m_iEncryption = iEncryption;
}

CNetFtp::~CNetFtp(void)
{
}

