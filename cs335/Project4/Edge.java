import java.lang.Math;

public class Edge {
	//Private members
	private Vertex source;
	private Vertex destination;
	private double weight;
	//Constructor
	public Edge(Vertex source, Vertex destination) {
		this.source = source;
		this.destination = destination;
		//Calculate weight of edge for the given vertices
		this.weight = findWeight(source,destination);
	}
	//Empty Constructor
	public Edge() {}

	private double findWeight(Vertex a, Vertex b) {
	/* Calculates the weight of Edge(a,b) using the
	   Euclidean distance formula. */
		int x = b.getX() - a.getX();
		int y = b.getY() - a.getY();
		double n = 1.0*(x*x + y*y);
		return Math.sqrt(n);
	}

	//Getters
	public Vertex getSource() {return source;}
	public Vertex getDestination() {return destination;}
	public double getWeight() {return weight;}

	//Setters
	public void setSource(Vertex v) {source = v;}
	public void setDestination(Vertex v) {destination = v;}
}