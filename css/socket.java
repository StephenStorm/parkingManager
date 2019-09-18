import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;
public class gprs{
	//private static List<Socket> clients = new LinkedList<Socket>();
	private static Map<String, Socket> clients=new LinkedHashMap<String, Socket>();
	static PrintWriter pw = null;
	static FileWriter fw = null;
	public static void main(String[] args) {
		int port = 10001;
		try {
			ServerSocket server = new ServerSocket(port);
 
			while (true) {
 
				// 获得客户端连接
				// 阻塞式方法
				System.out.println("准备阻塞...");
				final Socket client = server.accept();
				System.out.println("阻塞完成...");
				new Thread(new Runnable() {
					@Override
					public void run() {
					try {
						InputStream is = client.getInputStream();
						//获取输出流 给客服的写数据
						OutputStream os = client.getOutputStream();
						byte[] buffer = new byte[1024];
						int len = -1;
						System.out.println("准备read...");
						while ((len = is.read(buffer)) != -1) {
							String text=new String(buffer,0,len);
							System.out.println(text);
							System.out.println("read完成...");
							
							if(text.startsWith("#"))
							{
								clients.put(text, client);
								os.write("认证成功".getBytes());
							}else{
								os.write("收到了你的请求".getBytes());
//								String[] split = text.split(":");
//								String key="#"+split[0];
//								String content=split[1];
								// 关联文件
								File file = new File("c:\\123.txt");
								if(!file.exists()){
									// 判断文件不存在就new新文件,写数据
									try {
										file.createNewFile();
										// java IO流和文件关联
										pw = new PrintWriter(file);
										pw.print(text + "\t");
										pw.println();
										pw.flush();
									} catch (IOException e) {
										// TODO Auto-generated catch block
										e.printStackTrace();
									}
									
								}else{
									// 判断文件存在,就以FileWriter文件追加的方式写文件
									try {
										fw = new FileWriter("c:\\123.txt",true);
										fw.write(text + "\r\n");
										fw.flush();
									} catch (IOException e) {
										// TODO Auto-generated catch block
										e.printStackTrace();
									}
								}
								
//								Socket s = clients.get(key);
//								if(s!=null){
//									OutputStream output = s.getOutputStream();
//									 output.write(content.getBytes());
//								}
							}
						}
						} 
						catch (Exception e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}
					}
				}).start();
 
		}
 
	}
		catch (Exception e) {
			e.printStackTrace();
		}
}
}
