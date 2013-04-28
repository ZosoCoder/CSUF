import java.io.*;
import java.util.*;

public class Prim {
	public static void main(String[] args) {
		//Create file reader
		BufferedReader reader = null;
		try {
			reader = new BufferedReader(new FileReader("disneyland.txt"));
		} catch (FileNotFoundException e) {
			System.out.println("Error: " + e);
		}
		//Initialize variables for reading from the file
		String strRead = "";
		int size = 84;
		//Graph that contains adjacency matrix
		MyGraph disneyland = new MyGraph(size+1);
		//List to hold a vertex for each location in the file
		List<Vertex> vertices = new ArrayList<Vertex>();
		//Read file
		try {
			int count = 0;
			//Read and discard first line.
			reader.readLine();
			while ((strRead = reader.readLine()) != null && count < size) {
				/* Separate the line using a space delimiter and assign the value
				   to its corresponding variable */
				String splitArray[] = strRead.split(" ");
				int id = Integer.parseInt(splitArray[0]);
				int x = Integer.parseInt(splitArray[1]);
				int y = Integer.parseInt(splitArray[2]);
				String name = splitArray[3];
				//Create a new Vertex
				Vertex vert = new Vertex(id,x,y,name);
				vertices.add(vert);
				count++;
			}
		} catch (IOException e) {
			System.out.println("Error: " + e);
		}
		//Fill the adjacency matrix
		for (int i=0; i<size; i++) {
			for (int j=0; j<size; j++) {
				//Add edge to graph
				if (i!=j)
					disneyland.addEdge(vertices.get(i),vertices.get(j));
			}
		}

		//---- Graph is created. Begin Prim's Algorithm ----\\
		System.out.println("Loaded graph.");
		//Set start value for timer.
		long start = System.nanoTime();
		//Create a Set to hold the edges of the MST
		Set<Edge> edges = new LinkedHashSet<Edge>();
		//Create a PriorityQueue to hold the available edges for the algorithm
		PriorityQueue<Edge> availableEdges = new PriorityQueue<Edge>(84, new Comparator<Edge>() {
			/* Compares the weight of the two edges */
			public int compare(Edge e0, Edge e1) {
				double w0 = e0.getWeight();
				double w1 = e1.getWeight();
				if (w1 > w0) return -1;
				else if (w1 < w0) return 1;
				else return 0;
			}
		});
		//Create a list to hold the visited vertices
		List<Vertex> visited = new ArrayList<Vertex>();
		//Pick some arbitrary vertex
		Vertex someV = vertices.get(1);
		//Add the vertex to visited list.
		visited.add(someV);
		//Add all edges adjacent to vertex someV to availableEdges PQ
		for (Vertex v : vertices) {
			if (disneyland.hasEdge(someV,v))
				availableEdges.add(new Edge(someV,v));
		}
		//Initialize variables
		double weight = 0.0;			//Total weight
		Edge e = new Edge();			//Variable edge for algorithm
		Vertex v0 = new Vertex();		//Variable source vertex
		Vertex v1 = new Vertex();		//Variable destination vertex
		//Repeat n-1 times
		for (int i=0; i<size-1; i++) {
			while (!availableEdges.isEmpty()) {
				e = availableEdges.remove();
				v0 = e.getSource();
				v1 = e.getDestination();
				/* If an edge is found with a vertex that is not yet
				   visited, break from the loop. */
				if (visited.contains(v0) && !visited.contains(v1))
					break;
			}
			//Add new min edge to MST edges
			edges.add(e);
			//Add the weight of the appended edge to the total
			weight += e.getWeight();
			//Add the destination vertex to the visited list
			visited.add(v1);
			//Add all edges adjacent to v1 to availableEdges PQ
			for (Vertex v : vertices){
				if (v!=v1 && disneyland.hasEdge(v1,v))
					availableEdges.add(new Edge(v1,v));
			}
		}
		//Get elapsed time
		long elapsed = System.nanoTime() - start;
		//Output algorithm duration
		System.out.format("Prim's Algorithm took %.2f seconds\n",(elapsed/1000000000.0));
		//Output the MST Edges and total weight
		System.out.println("MST Edges:");
		for (Edge ed : edges) {
			v0 = ed.getSource();
			v1 = ed.getDestination();
			System.out.format("(%d)[%s] <-> (%d)[%s] Weight: %.02f\n",v0.getId(),v0.getName(),
							v1.getId(),v1.getName(),ed.getWeight());
		}
		System.out.format("Total Weight: %.02f",weight);
	}
}
