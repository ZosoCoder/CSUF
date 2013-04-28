import java.lang.Math;
import java.util.*;

public class MyGraph {
	//Private members
	private boolean[][] adjMatrix;
	private int vertices;
	private int edges;
	//Constructor
	public MyGraph(int n) { 
		vertices = n; 
		edges = 0;
		//Initialize adjacency matrix
		adjMatrix = new boolean[n][n]; 
		for (int i=0; i<vertices; i++) { 
			for (int j=0; j<vertices; j++) { 
				adjMatrix[i][j] = false; 
			} 
		} 
	}

	public boolean hasVertex(Vertex v) {
	/* Validates that the given vertex is valid for this graph.
	   Returns true if 0 <= vertex.id <= vertices */
		int n = v.getId();
		return (n >= 0) && (n < vertices);
	}

	public void addEdge(Vertex v0, Vertex v1) {
	/* Adds an edge to the adjacency matrix */
		if (hasVertex(v0) && hasVertex(v1)) {
			int origin = v0.getId();
			int dest = v1.getId();
			adjMatrix[origin][dest] = true;
			edges++;
		}
	}

	public boolean hasEdge(Vertex v0, Vertex v1) {
	/* Validates that there is an Edge(v0,v1) in this graph.
	   Returns true if adjMatric[v0][v1] is true. */
		int origin = v0.getId();
		int dest = v1.getId();
		return adjMatrix[origin][dest];
	}
}