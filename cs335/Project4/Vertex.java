public class Vertex {
	private int id;
	private int x;
	private int y;
	private String name;

	public Vertex(int id, int x, int y, String name) {
		this.id = id;
		this.x = x;
		this.y = y;
		this.name = name;
	}

	public Vertex() {}

	public int getId() {return id;}
	public int getX() {return x;}
	public int getY() {return y;}
	public String getName() {return name;}
}