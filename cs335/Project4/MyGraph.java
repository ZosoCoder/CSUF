import java.lang.Math;
import java.util.*;

public class MyGraph {
	private boolean[][] adjMatrix;
	private int vertices;
	private int edges;

	public MyGraph(int n) { 
		vertices = n; 
		edges = 0; 
		adjMatrix = new boolean[n][n]; 
		for (int i=0; i<vertices; i++) { 
			for (int j=0; j<vertices; j++) { 
				adjMatrix[i][j] = false; 
			} 
		} 
	}

	public boolean hasVertex(Node v) {
		int n = v.getId();
		return (n >= 0) && (n < vertices);
	}

	public void addEdge(Node v0, Node v1) {
		if (hasVertex(v0) && hasVertex(v1)) {
			int origin = v0.getId();
			int dest = v1.getId();
			adjMatrix[origin][dest] = true;
			edges++;
		}
	}

	public boolean hasEdge(Node v0, Node v1) {
		int origin = v0.getId();
		int dest = v1.getId();
		return adjMatrix[origin][dest];
	}
}