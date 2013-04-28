import java.lang.Math;

public class Edge {
	private Node source;
	private Node destination;
	private double weight;

	public Edge(Node source, Node destination) {
		this.source = source;
		this.destination = destination;
		this.weight = findWeight(source,destination);
	}

	public Edge() {}

	private double findWeight(Node a, Node b) {
		int x = b.getX() - a.getX();
		int y = b.getY() - a.getY();
		double n = 1.0*(x*x + y*y);
		return Math.sqrt(n);
	}

	public Node getSource() {return source;}
	public Node getDestination() {return destination;}
	public double getWeight() {return weight;}
}