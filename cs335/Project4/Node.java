public class Vertex {
	//Private members
	private int id;
	private int x;
	private int y;
	private String name;
	//Constructor
	public Vertex(int id, int x, int y, String name) {
		this.id = id;
		this.x = x;
		this.y = y;
		this.name = name;
	}
	//Empty Constructor
	public Vertex() {}
	//Getters
	public int getId() {return id;}
	public int getX() {return x;}
	public int getY() {return y;}
	public String getName() {return name;}
	//Setters
	public void setId(int id) {this.id = id;}
	public void setX(int x) {this.x = x;}
	public void setY(int y) {this.y = y;}
	public void setName(String name) {this.name = name;}
}