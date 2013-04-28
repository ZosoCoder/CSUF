import java.lang.Math;

public class Graph {
	private int[][] adjMatrix;
	private int vertices;
	private int edges;

	public Graph(int n) {
		vertices = n;
		edges = 0;
		adjMatrix = new int[n][n];
		for (int i=0; i<vertices; i++) {
			for (int j=0; j<vertices; j++) {
				adjMatrix[i][j] = null;
			}
		}
	}

	public int numVertices() {
		return vertices;
	}

	public int numEdges() {
		return edges;
	}

	public boolean hasVertex(Node v) {
		return (v >= 0) && (v < vertices);
	}

	public void addEdge(Node v0, Node v1) {
		if (hasVertex(v1) && hasVertex(v2)) {
			if (!adjMatrix[v0][v1]) {
				adjMatrix[v0][v1] = getEdgeWeight(v0,v1);
				edges++;
			}
		}
	}

	public double getEdgeWeight(Node v0, Node v1) {
		double n = 1.0*((v1.x - v0.x)*(v1.x-v0.x) + (v1.y - v0.y)*(v1.y-v0.y))
		return Math.sqrt(n);
	}


}